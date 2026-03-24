<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\App;
use Zyo\Core\Kernel;

class AppTest extends TestCase
{
    protected function setUp(): void
    {
        App::clearInstance();
    }

    public function test_it_is_a_singleton(): void
    {
        $app1 = App::getInstance();
        $app2 = App::getInstance();

        $this->assertSame($app1, $app2);
    }

    public function test_it_can_set_and_get_base_path(): void
    {
        $app = App::getInstance();
        $app->setBasePath('/tmp/zyophp');

        $this->assertEquals('/tmp/zyophp', $app->basePath());
        $this->assertEquals('/tmp/zyophp/app', $app->path());
        $this->assertEquals('/tmp/zyophp/app/Config', $app->configPath());
    }

    public function test_it_registers_paths_in_the_container_automatically(): void
    {
        $app = App::getInstance();
        $app->setBasePath('/var/www');

        $this->assertEquals('/var/www', $app->get('path.base'));
        $this->assertEquals('/var/www/app', $app->get('path'));
    }

    public function test_it_can_be_reset_for_testing(): void
    {
        $app1 = App::getInstance();
        App::clearInstance();
        $app2 = App::getInstance();

        $this->assertNotSame($app1, $app2);
    }

    public function test_helpers_are_integrated_with_the_app_singleton(): void
    {
        $app = App::getInstance();
        $app->setBasePath('/var/www');

        $this->assertSame($app, app());
        $this->assertEquals('/var/www', base_path());
    }

    public function test_it_can_run_the_application(): void
    {
        $app = App::getInstance();
        $app->setBasePath('/var/www');
        
        // Mock do Kernel se necessário, mas aqui vamos testar a chamada real
        $this->expectOutputString(""); // O Kernel:handle atual não retorna nada no console
        $app->run();
        
        $this->assertTrue(true);
    }
}