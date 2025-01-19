<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Course;
use app\models\Category;

class ErrorController extends Controller
{
    public function notFound() {
        return $this->render('404');
    }
    
}