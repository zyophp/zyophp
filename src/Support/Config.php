<?php

  namespace Zyo\Support;

  class Config
  {
      /**
       * @var array
       */
      protected array $items = [];

      /**
       * Create a new config instance.
       *
       * @param array $items
       */
      public function __construct(array $items = [])
      {
          $this->items = $items;
      }

    /**
     * Get the specified configuration value.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string|null $key = null, mixed $default = null): mixed
      {
          if (is_null($key)) {
              return $this->items;
          }

          if (isset($this->items[$key])) {
              return $this->items[$key];
          }

          $array = $this->items;
          foreach (explode('.', $key) as $segment) {
              if (is_array($array) && array_key_exists($segment, $array)) {
                  $array = $array[$segment];
              } else {
                  return $default;
              }
          }

          return $array;
      }

      /**
       * Set a given configuration value.
       *
       * @param string $key
       * @param mixed $value
       * @return void
       */
      public function set(string $key, mixed $value): void
      {
          $keys = explode('.', $key);
          $array = &$this->items;

          while (count($keys) > 1) {
              $k = array_shift($keys);
              if (!isset($array[$k]) || !is_array($array[$k])) {
                  $array[$k] = [];
              }
              $array = &$array[$k];
          }

          $array[array_shift($keys)] = $value;
      }

      /**
       * Load all configuration files from the given directory.
       *
       * @param string $path
       * @return void
       */
      public function loadFromDirectory(string $path): void
      {
          if (!is_dir($path)) {
              return;
          }

          foreach (glob($path . '/*.php') as $file) {
              $key = basename($file, '.php');
              $this->set($key, require $file);
          }
      }
  }
