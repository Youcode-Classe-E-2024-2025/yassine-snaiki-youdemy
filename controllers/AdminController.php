<?php

namespace app\controllers;
use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Category;
use app\models\Course;
use app\models\Student;
use app\models\Tag;
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
        $categories = Category::getAll();
        $coursesPerCategory = [];
        foreach ($categories as $category) {
            $coursesPerCategory[$category->getName()] = $category->count();
        }   
        return $this->render('admin-dashboard',[
            'coursesNum' => Course::count(),
            'coursesPerCategory' => $coursesPerCategory,
            'mostEnrolled' => Course::mostEnrolled(),
            'top3Teachers' => Teacher::top3(),
            'studentsNum' => Student::count(),
            'teachersNum' => Teacher::count(),
        ]);
    }
    public function teachers($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $pagesNum = ceil(Teacher::count() / $limit);
        $pagesNum = max($pagesNum,1);
        $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
        $offset = ($page -1) * $limit;
        return $this->render('admin-teachers',[
            'teachers' => Teacher::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function students($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $pagesNum = ceil(Student::count() / $limit);
        $pagesNum = max($pagesNum,1);
        $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
        $offset = ($page -1) * $limit;
        return $this->render('admin-students',[
            'students' => Student::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function blacklist($request) {
        $page = isset($request->getBody()['page']) ? (int)$request->getBody()['page'] :1;
        $limit = 10;
        $pagesNum = ceil(User::suspendedCount() / $limit);
        $pagesNum = max($pagesNum,1);
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
        $pagesNum = ceil(TeachingRequest::count() / $limit);
        $pagesNum = max($pagesNum,1);
        $page = ($page >$pagesNum) ? $pagesNum : (($page < 1) ? 1 : $page);
        $offset = ($page -1) * $limit;
        return $this->render('admin-requests',[
            'requests' => TeachingRequest::getPaginated($limit,$offset),
            'pagesNum' => $pagesNum,
            'currPage' => $page,
        ]);
    }
    public function categories($request){
        return $this->render('admin-categories',[
            'categories' => Category::getAll(),
            'tags' => Tag::getAll(),
        ]);
    }
    public function acceptRequest($request) {
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['id'])){
            header('Location: /404');
            exit;
        }
        $id = $request->getBody()['id'];
        $teachingRequest = TeachingRequest::findById($id);
   
        if($teachingRequest){
            $teachingRequest->accept();
        }
        header('Location: /admin/requests');
        exit;
    }
    public function rejectRequest($request) {
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['id'])){
            header('Location: /404');
            exit;
        }
        $id = $request->getBody()['id'];
        $teachingRequest = TeachingRequest::findById($id);
   
        if($teachingRequest){
            $teachingRequest->delete();
        }
        header('Location: /admin/requests');
        exit;
    }
    public function suspend($request) {
        
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['user_id'])){
            header('Location: /404');
            exit;
        }
        $id = $request->getBody()['user_id'];
        $user = User::findById($id);
        if($user){
            $user->setIsactive(false);
            $user->update();
        }
        header('Location: /admin/blacklist');
    }
    public function activate($request) {
        
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['user_id'])){
            header('Location: /404');
            exit;
        }
        $id = $request->getBody()['user_id'];
        $user = User::findById($id);
        if($user){
            $user->setIsactive(true);
            $user->update();
        }
        header('Location: /admin/blacklist');
    }
    public function deleteTag($request) {
        
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['tag_name'])){
            header('Location: /404');
            exit;
        }
        $name = $request->getBody()['tag_name'];
        $tag = Tag::getByName($name);
        if($tag){
            $tag->delete();
        }
        header('Location: /admin/categories');
    }
    public function deleteCategory($request) {
        
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['category_name'])){
            header('Location: /404');
            exit;
        }
        $name = $request->getBody()['category_name'];
        $category = Category::getByName($name);
        if($category){
            $category->delete();
        }
        header('Location: /admin/categories');
    }
    public function addCategory($request) {
        
        if($request->getRole() !== 'admin'){
            header('Location: /');
            exit;
        }
        if(!isset($request->getBody()['category'])){
            header('Location: /404');
            exit;
        }
        $name = $request->getBody()['category'];
        $category = new Category($name);
        $category->save();
        header('Location: /admin/categories');
    }
    public function addTags($request) {
        if($request->getRole() !== 'admin'){
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['tags']) || !is_array($data['tags'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
            return;
        }

        $tags = array_unique($data['tags']);
        
        try {
            foreach ($tags as $tagName) {
                $tag = new Tag($tagName);
                $tag->save();
            }
            echo json_encode(['status' => 'success']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}