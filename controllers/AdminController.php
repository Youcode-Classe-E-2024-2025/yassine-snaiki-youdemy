<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Student;
use app\models\Teacher;
use app\models\TeachingRequest;
use app\models\User;



class AdminController extends Controller
{
    public function __construct($request) {
        if ($request->getRole() !== 'admin') {
            http_response_code(403);
            header('Location: /login');
            exit;
        }
    }
    public function dashboard() {
        return $this->render('admin-dashboard',[
            'teachers' => Teacher::getAll(),
            'students' => Student::getAll(),
        ]);
    }
    public function teachers($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $offset = ($page -1) * $limit;
        $pagesNum = ceil(Teacher::count() / $limit);
        return $this->render('admin-teachers',[
            'teachers' => Teacher::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function students($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $offset = ($page -1) * $limit;
        $pagesNum = ceil(Student::count() / $limit);
        return $this->render('admin-students',[
            'students' => Student::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function blacklist($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $pagesNum = ceil(User::suspendedCount() / $limit) || 1;
        $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
        $offset = ($page -1) * $limit;
        return $this->render('admin-blacklist',[
            'users' => User::getSuspendedPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function requests($request){
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $offset = ($page -1) * $limit;
        $pagesNum = ceil(TeachingRequest::count() / $limit);
        return $this->render('admin-requests',[
            'requests' => TeachingRequest::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    // public function acceptRequest($request) {
    //     $request_id = 
    // }
}