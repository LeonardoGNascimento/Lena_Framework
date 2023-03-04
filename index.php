<?php

include_once './App/Core/AutoLoad.php';

use App\Core\App;
use App\Core\Config;
use App\Usuario\Controller\UsuarioController;

Autoloader::register();
Config::config();

$app = new App();

$app->get('usuario/', UsuarioController::class, 'lista');
$app->post('usuario/', UsuarioController::class, 'cadastra');
$app->patch('usuario/', UsuarioController::class, 'atualiza');
$app->run();
