<?php

require_once './vendor/autoload.php';

use Lena\Core\App;
use Lena\Core\Config;
use Lena\Usuario\Controller\UsuarioController;

Config::config();

$app = new App();

$app->get('usuario/', UsuarioController::class, 'lista');
$app->post('usuario/', UsuarioController::class, 'cadastra');
$app->patch('usuario/', UsuarioController::class, 'atualiza');

$app->run();
