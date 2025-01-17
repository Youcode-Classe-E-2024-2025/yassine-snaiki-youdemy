<?php

use app\controllers\AdminController;
use app\controllers\AuthController;
use app\core\Application;
require_once __DIR__."/../vendor/autoload.php";



session_start();

$app = new Application(dirname(__DIR__));

$app->router->get('/',[AdminController::class,'dashboard']);
$app->router->get('/admin/dashboard',[AdminController::class,'dashboard']);
$app->router->get('/admin/teachers',[AdminController::class,'teachers']);
$app->router->get('/admin/students',[AdminController::class,'students']);
$app->router->get('/admin/requests',[AdminController::class,'requests']);
$app->router->get('/admin/blacklist',[AdminController::class,'blacklist']);


$app->router->post('/accept-request',[AdminController::class,'requests']);
$app->router->post('/reject-request',[AdminController::class,'requests']);

$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/logout',[AuthController::class,'logout']);
$app->router->get('/register',[AuthController::class,'register']);

$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);


$app->run();