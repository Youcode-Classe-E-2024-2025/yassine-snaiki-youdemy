<?php

use app\controllers\AuthController;
use app\core\Application;
require_once __DIR__."/../vendor/autoload.php";



session_start();

$app = new Application(dirname(__DIR__));

$app->router->get('/',"courses");

$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/register',[AuthController::class,'register']);

$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);


$app->run();