<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Course;
use app\models\Category;

class HomeController extends Controller
{
    public function home() {
        return $this->render('home', [
            'featuredCourses' => Course::getFeatured(),
            'categories' => Category::getUsedCategories(),
        ]);
    }
    
}