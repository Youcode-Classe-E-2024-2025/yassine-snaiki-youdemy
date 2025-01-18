<?php

use app\controllers\CoursesController;
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\AuthController;
use app\core\Application;
require_once __DIR__."/../vendor/autoload.php";



session_start();

$app = new Application(dirname(__DIR__));

$app->router->get('/',[HomeController::class,'home']);
$app->router->get('/courses',[CoursesController::class,'courses']);
$app->router->get('/admin/dashboard',[AdminController::class,'dashboard']);
$app->router->get('/admin/teachers',[AdminController::class,'teachers']);
$app->router->get('/admin/students',[AdminController::class,'students']);
$app->router->get('/admin/requests',[AdminController::class,'requests']);
$app->router->get('/admin/blacklist',[AdminController::class,'blacklist']);
$app->router->get('/admin/categories',[AdminController::class,'categories']);


$app->router->post('/accept-request',[AdminController::class,'requests']);
$app->router->post('/reject-request',[AdminController::class,'requests']);

$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/logout',[AuthController::class,'logout']);
$app->router->get('/register',[AuthController::class,'register']);

$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);


$app->run();