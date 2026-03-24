<?php

namespace Zyo\Core;

  use Psr\Container\ContainerInterface;
  use Psr\Container\ContainerExceptionInterface;
  use Psr\Container\NotFoundExceptionInterface;
  use ReflectionClass;
  use ReflectionParameter;
  use Exception;

  class Container implements ContainerInterface
  {
      /**
       * @var array
       */
      protected array $bindings = [];

      /**
       * @var array
       */
      protected array $instances = [];

      /**
       * @var array
       */
      protected array $buildStack = [];

      /**
       * Register a binding with the container.
       *
       * @param string $abstract
       * @param mixed|null $concrete
       * @param bool $shared
       * @return void
       */
      public function bind(string $abstract, mixed $concrete = null, bool $shared = false): void
      {
          if (is_null($concrete)) {
              $concrete = $abstract;
          }

          $this->bindings[$abstract] = [
              'concrete' => $concrete,
              'shared' => $shared
          ];
      }

      /**
       * Register an existing instance as shared in the container.
       *
       * @param string $abstract
       * @param mixed $instance
       * @return mixed
       */
      public function instance(string $abstract, mixed $instance): mixed
      {
          $this->instances[$abstract] = $instance;
          return $instance;
      }

      /**
       * Register a shared binding in the container.
       *
       * @param string $abstract
       * @param mixed|null $concrete
       * @return void
       */
      public function singleton(string $abstract, mixed $concrete = null): void
      {
          $this->bind($abstract, $concrete, true);
      }

      /**
       * Resolve the given type from the container.
       *
       * @param string $id
       * @return mixed
       * @throws Exception
       */
      public function get(string $id): mixed
      {
          if ($this->hasInstance($id)) {
              return $this->instances[$id];
          }

          $concrete = $this->getConcrete($id);

          if ($this->isBuildable($concrete, $id)) {
              $object = $this->build($concrete);
          } else {
              $object = $this->get($concrete);
          }

          if ($this->isShared($id)) {
              $this->instances[$id] = $object;
          }

          return $object;
      }

      /**
       * Determine if the given abstract type has been bound.
       *
       * @param string $id
       * @return bool
       */
      public function has(string $id): bool
      {
          return isset($this->bindings[$id]) || isset($this->instances[$id]);
      }

      /**
       * Get the concrete type for a given abstract.
       *
       * @param string $abstract
       * @return mixed
       */
      protected function getConcrete(string $abstract): mixed
      {
          if (!isset($this->bindings[$abstract])) {
              return $abstract;
          }

          return $this->bindings[$abstract]['concrete'];
      }

      /**
       * Determine if a given type is shared.
       *
       * @param string $abstract
       * @return bool
       */
      protected function isShared(string $abstract): bool
      {
          return isset($this->instances[$abstract]) ||
                 (isset($this->bindings[$abstract]['shared']) && $this->bindings[$abstract]['shared'] === true);
      }

      /**
       * Check if instance already exists.
       *
       * @param string $id
       * @return bool
       */
      protected function hasInstance(string $id): bool
      {
          return isset($this->instances[$id]);
      }

      /**
       * Determine if the concrete is buildable.
       *
       * @param mixed $concrete
       * @param string $abstract
       * @return bool
       */
      protected function isBuildable(mixed $concrete, string $abstract): bool
      {
          return $concrete === $abstract || $concrete instanceof \Closure;
      }

      public function build(mixed $concrete): mixed
      {
          if ($concrete instanceof \Closure) {
              return $concrete($this);
          }

          if (in_array($concrete, $this->buildStack)) {
              throw new Exception("Circular dependency detected for class: {$concrete}");
          }

          $this->buildStack[] = $concrete;

          try {
              $reflector = new ReflectionClass($concrete);

              if (!$reflector->isInstantiable()) {
                  throw new Exception("Class {$concrete} is not instantiable");
              }

              $constructor = $reflector->getConstructor();

              if (is_null($constructor)) {
                  array_pop($this->buildStack);
                  return new $concrete;
              }

              $parameters = $constructor->getParameters();
              $instances = $this->resolveDependencies($parameters);

              array_pop($this->buildStack);

              return $reflector->newInstanceArgs($instances);
          } catch (Exception $e) {
              array_pop($this->buildStack);
              throw $e;
          }
      }

      /**
       * Resolve all of the dependencies from the ReflectionParameters.
       *
       * @param array $parameters
       * @return array
       * @throws Exception
       */
      protected function resolveDependencies(array $parameters): array
      {
          $dependencies = [];

          foreach ($parameters as $parameter) {
              $dependencies[] = $this->resolve($parameter);
          }

          return $dependencies;
      }

      /**
       * Resolve a single dependency from the container.
       *
       * @param ReflectionParameter $parameter
       * @return mixed
       * @throws Exception
       */
      protected function resolve(ReflectionParameter $parameter): mixed
      {
          $type = $parameter->getType();

          if (!$type || $type->isBuiltin()) {
              if ($parameter->isDefaultValueAvailable()) {
                  return $parameter->getDefaultValue();
              }

              throw new Exception("Unresolvable dependency [{$parameter}] in class {$parameter->getDeclaringClass()->getName()}");
          }

          return $this->get($type->getName());
      }
  }
