<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\App;
use Zyo\Core\ServiceProvider;

class ServiceProviderTest extends TestCase
{
    protected App $app;

    protected function setUp(): void
    {
        App::clearInstance();
        $this->app = App::getInstance();
    }

    public function test_it_can_register_services_into_the_app(): void
    {
        $provider = new class($this->app) extends ServiceProvider {
            public function register(): void {
                $this->app->instance('foo', 'bar');
            }
        };

        $provider->register();

        $this->assertEquals('bar', $this->app->get('foo'));
    }

    public function test_it_has_a_boot_method(): void
    {
        $provider = new class($this->app) extends ServiceProvider {
            public bool $booted = false;
            public function register(): void {}
            public function boot(): void { $this->booted = true; }
        };

        $provider->boot();

        $this->assertTrue($provider->booted);
    }

    public function test_it_covers_base_boot_method(): void
    {
        $provider = new class($this->app) extends ServiceProvider {
            public function register(): void {}
        };

        // Chama o método boot vazio da classe base para cobertura
        $provider->boot();
        $this->assertTrue(true);
    }
}