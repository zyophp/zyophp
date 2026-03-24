<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\App;
use Zyo\Support\Config;

class HelpersTest extends TestCase
{
    protected function setUp(): void
    {
        App::clearInstance();
    }

    public function test_app_helper_returns_container_instance(): void
    {
        $this->assertInstanceOf(App::class, app());
    }

    public function test_app_helper_resolves_abstract_from_container(): void
    {
        $app = App::getInstance();
        $app->instance('foo', 'bar');
        
        $this->assertEquals('bar', app('foo'));
    }

    public function test_config_helper_returns_config_instance(): void
    {
        $app = App::getInstance();
        $app->instance('config', new Config());
        
        $this->assertInstanceOf(Config::class, config());
    }

    public function test_config_helper_gets_value(): void
    {
        $app = App::getInstance();
        $app->instance('config', new Config(['app' => ['name' => 'ZyoPHP']]));
        
        $this->assertEquals('ZyoPHP', config('app.name'));
        $this->assertEquals('default', config('missing', 'default'));
    }

    public function test_config_helper_sets_values_using_array(): void
    {
        $app = App::getInstance();
        $config = new Config();
        $app->instance('config', $config);
        
        config(['app.timezone' => 'UTC', 'mail.driver' => 'smtp']);
        
        $this->assertEquals('UTC', $config->get('app.timezone'));
        $this->assertEquals('smtp', $config->get('mail.driver'));
    }

    public function test_path_helpers(): void
    {
        $app = App::getInstance();
        $app->setBasePath('/var/www');
        
        $this->assertEquals('/var/www', base_path());
        $this->assertEquals('/var/www/app/Config', config_path());
        $this->assertEquals('/var/www/storage', storage_path());
        
        $this->assertEquals('/var/www/foo', base_path('foo'));
        $this->assertEquals('/var/www/app/Config/bar.php', config_path('bar.php'));
        $this->assertEquals('/var/www/storage/logs/error.log', storage_path('logs/error.log'));
    }
}
