<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Course;
use app\models\Category;

class CoursesController extends Controller
{
    public function courses($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        
        $limit = 9;
        
        if(isset($request->getBody()['category'])) {
            $cg = $request->getBody()['category'];
            $pagesNum = ceil(Course::countInCategory($cg) / $limit);
            $pagesNum = max($pagesNum,1);
            $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
            $offset = ($page -1) * $limit;
            return $this->render('courses',[
                'courses' => Course::getCategoryPaginated($cg,$limit,$offset),
                'cg' => $cg,
                'categories' => Category::getUsedCategories(),
                'pagesNum' => $pagesNum,
                'currPage' => $page,
            ]);
        }
        if(isset($request->getBody()['q'])) {
            $query = urldecode($request->getBody()['q']);
            $pagesNum = ceil(Course::countInSearch($query) / $limit);
            $pagesNum = max($pagesNum,1);
            $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
            $offset = ($page -1) * $limit;
            return $this->render('courses',[
                'courses' => Course::getSearchPaginated($query,$limit,$offset),
                'query' => $query,
                'categories' => Category::getUsedCategories(),
                'pagesNum' => $pagesNum,
                'currPage' => $page,
            ]);
        }
        $pagesNum = ceil(Course::count() / $limit);
        $pagesNum= max($pagesNum,1);
        $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
        $offset = ($page -1) * $limit;
        return $this->render('courses',[
            'courses' => Course::getPaginated($limit,$offset),
            'categories' => Category::getUsedCategories(),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }

    public function course($request) {
        if(!isset($request->getBody()['id'])) {
            header('Location: /courses');
            exit;
        }
        $course = Course::getById($request->getBody()['id']);
        if(!$course) {
            http_response_code(404);
            return $this->render('404');
        }
        if(isset($_SESSION['user']['id']))
        return $this->render('course',[
            'course' => $course,
            'isEnrolled' => $course->isEnrolled($_SESSION['user']['id']),
        ]);
        return $this->render('course',[
            'course' => $course,
            'isEnrolled' => false,
        ]);

    }
    
}