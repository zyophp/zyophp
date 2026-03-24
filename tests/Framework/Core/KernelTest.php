<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\App;
use Zyo\Core\Kernel;
use Zyo\Support\Config;

class KernelTest extends TestCase
{
    protected App $app;
    protected Kernel $kernel;

    protected function setUp(): void
    {
        App::clearInstance();
        $this->app = App::getInstance();
        $this->app->setBasePath(realpath(__DIR__ . '/../../../'));
        $this->kernel = new Kernel($this->app);
    }

    public function test_it_can_bootstrap_the_application(): void
    {
        $this->kernel->bootstrap();

        $this->assertTrue($this->app->has('config'));
        $this->assertInstanceOf(Config::class, $this->app->get('config'));
        $this->assertEquals('ZyoPHP', config('app.name'));
    }

    public function test_it_can_handle_a_request(): void
    {
        $response = $this->kernel->handle("REQUEST_DATA");

        $this->assertEquals("REQUEST_DATA", $response);
    }
}