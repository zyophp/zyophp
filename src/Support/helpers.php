<?php

use \Zyo\Core\App;
use \Zyo\Support\Config;



  /**
   * ZyoPHP — Helpers Globais
   *
   * Funções utilitárias disponíveis em todo o projeto.
   * Registrado via autoload "files" no composer.json.
   */

  if (!function_exists('app')) {
      /**
       * Get the available container instance.
       *
       * @param string|null $abstract
       * @return mixed|App
       */
      function app($abstract = null)
      {
          if (is_null($abstract)) {
              return App::getInstance();
          }

          return App::getInstance()->get($abstract);
      }
  }

  if (!function_exists('config')) {
      /**
       * Get / set the specified configuration value.
       *
       * @param array|string|null $key
       * @param mixed|null $default
       * @return mixed|Config
       */
      function config($key = null, $default = null)
      {
          $config = app('config');

          if (is_null($key)) {
              return $config;
          }

          if (is_array($key)) {
              foreach ($key as $k => $v) {
                  $config->set($k, $v);
              }
              return null;
          }

          return $config->get($key, $default);
      }
  }

  if (!function_exists('base_path')) {
      /**
       * Get the path to the base of the install.
       *
       * @param string $path
       * @return string
       */
      function base_path($path = '')
      {
          return app()->basePath($path);
      }
  }

  if (!function_exists('config_path')) {
      /**
       * Get the path to the configuration files.
       *
       * @param string $path
       * @return string
       */
      function config_path($path = '')
      {
          return app()->configPath($path);
      }
  }

  if (!function_exists('storage_path')) {
      /**
       * Get the path to the storage directory.
       *
       * @param string $path
       * @return string
       */
      function storage_path($path = '')
      {
          return app()->storagePath($path);
      }
  }
