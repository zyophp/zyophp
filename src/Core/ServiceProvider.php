<?php

  namespace Zyo\Core;

  abstract class ServiceProvider
  {
      /**
       * @var App
       */
      protected App $app;

      /**
       * Create a new service provider instance.
       *
       * @param App $app
       */
      public function __construct(App $app)
      {
          $this->app = $app;
      }

      /**
       * Register any application services.
       *
       * @return void
       */
      abstract public function register(): void;

      /**
       * Bootstrap any application services.
       *
       * @return void
       */
      public function boot(): void
      {
          //
      }
  }
