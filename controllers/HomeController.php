<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Course;
use app\models\Category;

class HomeController extends Controller
{
    public function home() {
        if(isset($_SESSION['course_id'])){
            header("Location: /course?id={$_SESSION['course_id']}");
            unset($_SESSION["course_id"]);
            exit;
        }
        return $this->render('home', [
            'featuredCourses' => Course::getFeatured(),
            'categories' => Category::getUsedCategories(),
        ]);
    }
    
}