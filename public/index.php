<?php

/**
 * ZyoPHP — Front Controller
 *
 * Todas as requisições HTTP passam por aqui.
 */

define('ZYOPHP_START', microtime(true));
define('BASE_PATH', dirname(__DIR__));

// Autoload do Composer
require BASE_PATH . '/vendor/autoload.php';

// Bootstrap da aplicação
$app = require BASE_PATH . '/src/bootstrap.php';

// Executar o kernel
$app->run();
