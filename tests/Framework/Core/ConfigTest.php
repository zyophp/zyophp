<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Support\Config;

class ConfigTest extends TestCase
{
    protected Config $config;

    protected function setUp(): void
    {
        $this->config = new Config([
            'app' => [
                'name' => 'ZyoPHP',
                'debug' => true
            ],
            'database' => [
                'default' => 'mysql',
                'connections' => [
                    'mysql' => ['host' => '127.0.0.1']
                ]
            ]
        ]);
    }

    public function test_it_can_get_values_using_dot_notation(): void
    {
        $this->assertEquals('ZyoPHP', $this->config->get('app.name'));
        $this->assertTrue($this->config->get('app.debug'));
        $this->assertEquals('mysql', $this->config->get('database.default'));
        $this->assertEquals('127.0.0.1', $this->config->get('database.connections.mysql.host'));
    }

    public function test_it_get_top_level_key_without_dot_notation(): void
    {
        $this->assertIsArray($this->config->get('app'));
        $this->assertEquals('ZyoPHP', $this->config->get('app')['name']);
    }

    public function test_it_returns_default_value_for_missing_keys(): void
    {
        $this->assertEquals('default', $this->config->get('missing.key', 'default'));
        $this->assertNull($this->config->get('another.missing.key'));
        
        // Testa falha no meio do aninhamento (chave que não é array)
        $this->config->set('app.item', 'string-value');
        $this->assertEquals('default', $this->config->get('app.item.nested', 'default'));
    }

    public function test_it_can_set_values_using_dot_notation(): void
    {
        $this->config->set('app.timezone', 'UTC');
        $this->assertEquals('UTC', $this->config->get('app.timezone'));

        $this->config->set('mail.driver', 'smtp');
        $this->assertEquals('smtp', $this->config->get('mail.driver'));
    }

    public function test_it_can_return_entire_config_array(): void
    {
        $all = $this->config->get();
        $this->assertIsArray($all);
        $this->assertArrayHasKey('app', $all);
    }

    public function test_it_can_load_configs_from_directory(): void
    {
        $path = sys_get_temp_dir() . '/zyo_config_' . uniqid();
        mkdir($path);
        file_put_contents($path . '/services.php', "<?php return ['mail' => 'smtp'];");
        
        $this->config->loadFromDirectory($path);
        
        $this->assertEquals('smtp', $this->config->get('services.mail'));
        
        // Limpeza
        unlink($path . '/services.php');
        rmdir($path);
    }

    public function test_it_returns_early_if_directory_does_not_exist(): void
    {
        $this->config->loadFromDirectory('/non/existent/path');
        $this->assertArrayNotHasKey('non', $this->config->get());
    }

    public function test_it_handles_empty_directories_gracefully(): void
    {
        $path = sys_get_temp_dir() . '/zyo_empty_' . uniqid();
        mkdir($path);
        
        $initialConfig = $this->config->get();
        $this->config->loadFromDirectory($path);
        
        $this->assertEquals($initialConfig, $this->config->get());
        
        rmdir($path);
    }
}