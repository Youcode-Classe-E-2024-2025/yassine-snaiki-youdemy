<?php

use app\controllers\CoursesController;
use app\controllers\ErrorController;
use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\StudentController;

use app\controllers\AuthController;
use app\controllers\TeacherController;
use app\core\Application;
require_once __DIR__."/../vendor/autoload.php";



session_start();

$app = new Application(dirname(__DIR__));

$app->router->get('/',[HomeController::class,'home']);
$app->router->get('/404',[ErrorController::class,'notFound']);
$app->router->get('/courses',[CoursesController::class,'courses']);
$app->router->get('/course',[CoursesController::class,'course']);



$app->router->get('/admin/dashboard',[AdminController::class,'dashboard']);
$app->router->get('/admin/teachers',[AdminController::class,'teachers']);
$app->router->get('/admin/students',[AdminController::class,'students']);
$app->router->get('/admin/requests',[AdminController::class,'requests']);
$app->router->get('/admin/blacklist',[AdminController::class,'blacklist']);
$app->router->get('/admin/categories',[AdminController::class,'categories']);


$app->router->post('/accept-request',[AdminController::class,'acceptRequest']);
$app->router->post('/reject-request',[AdminController::class,'rejectRequest']);
$app->router->post('/suspend',[AdminController::class,'suspend']);
$app->router->post('/activate',[AdminController::class,'activate']);
$app->router->post('/delete-tag',[AdminController::class,'deleteTag']);
$app->router->post('/delete-category',[AdminController::class,'deleteCategory']);
$app->router->post('/add-category',[AdminController::class,'addCategory']);
$app->router->post('/add-tags',[AdminController::class,'addTags']);


$app->router->get('/mycourses',[StudentController::class,'myCourses']);
$app->router->get('/study/course',[StudentController::class,'studyCourse']);
$app->router->post('/enroll',[StudentController::class,'enroll']);


$app->router->get('/teacher/courses',[TeacherController::class,'courses']);
$app->router->get('/teacher/create',[TeacherController::class,'create']);
$app->router->get('/teacher/modify',[TeacherController::class,'modify']);
$app->router->get('/teacher/dashboard',[TeacherController::class,'dashboard']);
$app->router->post('/create-course',[TeacherController::class,'createCourse']);
$app->router->post('/add-tags-to-course',[TeacherController::class,'addTags']);
$app->router->post('/remove-tag-from-course',[TeacherController::class,'removeTag']);
$app->router->post('/change-title',[TeacherController::class,'changeTitle']);
$app->router->post('/change-description',[TeacherController::class,'changeDescription']);
$app->router->post('/change-category',[TeacherController::class,'changeCategory']);
$app->router->post('/delete-course',[TeacherController::class,'deleteCourse']);


$app->router->get('/login',[AuthController::class,'login']);
$app->router->get('/logout',[AuthController::class,'logout']);
$app->router->get('/register',[AuthController::class,'register']);

$app->router->post('/login',[AuthController::class,'handleLogin']);
$app->router->post('/register',[AuthController::class,'handleRegister']);


$app->run();