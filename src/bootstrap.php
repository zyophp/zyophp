<?php

/**
 * ZyoPHP — Bootstrap
 *
 * Inicializa a aplicação e retorna a instância do App.
 * Chamado pelo front controller (public/index.php).
 */

use Zyo\Core\App;

// Criar instância da aplicação
$app = App::getInstance();

// Registrar o caminho base
$app->setBasePath(BASE_PATH);

return $app;
