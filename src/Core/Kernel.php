<?php

  namespace Zyo\Core;

  class Kernel
  {
      /**
       * @var App
       */
      protected App $app;

      /**
       * Create a new kernel instance.
       *
       * @param App $app
       */
      public function __construct(App $app)
      {
          $this->app = $app;
      }

      /**
       * Handle the incoming request.
       *
       * @param mixed $request
       * @return mixed
       */
      public function handle(mixed $request): mixed
      {
          $this->bootstrap();

          // Por enquanto apenas retorna o request (Fase 3 implementará Request/Response reais)
          return $request;
      }

      /**
       * Bootstrap the application.
       *
       * @return void
       */
      public function bootstrap(): void
      {
          $this->app->instance('config', new \Zyo\Support\Config());
          $this->app->get('config')->loadFromDirectory($this->app->configPath());

          // Registrar outros serviços aqui...
      }
  }
