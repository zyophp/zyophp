<?php

namespace Tests\Framework\Core;

use PHPUnit\Framework\TestCase;
use Zyo\Core\App;

class BootstrapTest extends TestCase
{
    public function test_it_bootstraps_the_application(): void
    {
        if (!defined('BASE_PATH')) {
            define('BASE_PATH', realpath(__DIR__ . '/../../../'));
        }

        $app = require __DIR__ . '/../../../src/bootstrap.php';

        $this->assertInstanceOf(App::class, $app);
        $this->assertEquals(BASE_PATH, $app->basePath());
    }
}
