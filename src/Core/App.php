<?php

namespace Zyo\Core;

class App extends Container
{
    /**
     * @var string
     */
    protected string $basePath;

    /**
     * @var static|null
     */
    protected static ?self $instance = null;

    /**
     * Create a new application instance.
     */
    protected function __construct()
    {
        $this->instance(static::class, $this);
        $this->instance('app', $this);
    }

    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance(): static
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Clear the globally available instance of the container (mostly for testing).
     *
     * @return void
     */
    public static function clearInstance(): void
    {
        static::$instance = null;
    }

    /**
     * Set the base path for the application.
     *
     * @param string $path
     * @return $this
     */
    public function setBasePath(string $path): static
    {
        $this->basePath = rtrim($path, '\/');
        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer(): void
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.resources', $this->resourcesPath());
    }

    /**
     * Get the base path of the installation.
     *
     * @param string $path
     * @return string
     */
    public function basePath(string $path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get the path to the application directory.
     *
     * @param string $path
     * @return string
     */
    public function path(string $path = ''): string
    {
        return $this->basePath('app') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path
     * @return string
     */
    public function configPath(string $path = ''): string
    {
        return $this->basePath('app/Config') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get the path to the public / web directory.
     *
     * @param string $path
     * @return string
     */
    public function publicPath(string $path = ''): string
    {
        return $this->basePath('public') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get the path to the storage directory.
     *
     * @param string $path
     * @return string
     */
    public function storagePath(string $path = ''): string
    {
        return $this->basePath('storage') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string $path
     * @return string
     */
    public function resourcesPath(string $path = ''): string
    {
        return $this->basePath('app/Resources') . ($path ? DIRECTORY_SEPARATOR . $path : '');
    }

    /**
     * Run the application.
     *
     * @return void
     */
    public function run(): void
    {
        $kernel = $this->build(Kernel::class);
        $kernel->handle("Request Dummy");
    }
}
