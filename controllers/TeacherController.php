<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Category;
use app\models\Course;
use app\models\Tag;
use app\models\Teacher;
use app\models\User;

class TeacherController extends Controller
{

    public function __construct($request) {
        if ($request->getRole() !== 'teacher') {
            http_response_code(403);
            header('Location: /login');
            exit;
        }
    }

    public function dashboard($request){
        $user = User::findById( $_SESSION['user']['id'] );
        $teacher = new Teacher($user->getId(),$user->getEmail(),$user->getPassword(),$user->getusername());
        $courses = $teacher->getCourses();
        $courseNum = count($courses);
        $enrollPerCourse = [];

        return $this->render('teacher-dashboard',[
            'course' => $courses,
            'courseNum'=> $courseNum
        ]);
    }

    public function courses(){
        $id = $_SESSION['user']['id'];
        $user = User::findById( $id );
        $teacher = new Teacher($user->getId(),$user->getEmail(),$user->getPassword(),$user->getusername(),$user->getIsactive());
        $courses = $teacher->getCourses();
        return $this->render('teacher-courses',[
            'courses' => $courses,
        ]);
    }
    public function create(){
        $tags = Tag::getAll();
        $categories = Category::getAll();
       
        return $this->render('teacher-create',[
            'tags' => $tags,
            'categories'=> $categories,
        ]);
    }
    public function createCourse(Request $request){
        if($request->getRole() !== 'teacher'){
            header('Location: /');
            exit;
        }
        if(empty($request->getBody()['title']) || empty($request->getBody()['description']) || empty($request->getBody()['content_type']) || empty($request->getBody()['category_name'])){
            $_SESSION['message'] = 'Please fill all fields';
            header('Location: /teacher/create');
            exit;
        }  
        $body = $request->getBody();
        $content = $body['content'];
        $thumbnail = 'https://embed-ssl.wistia.com/deliveries/5cd59211cdc35bba92c2560fefd00527.webp?image_crop_resized=960x540';
        

        if (!empty($_FILES['thumbnail']['name'])) {
            $upload_dir = "uploads/";
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $thumbnail_name = uniqid() . '_' . basename($_FILES["thumbnail"]["name"]);
            $thumbnail_path = $upload_dir . $thumbnail_name;
            
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnail_path)) {
                $thumbnail = '/' . $thumbnail_path;
            }
        }

       
        if ($body['content_type'] === 'video') {
            if (!empty($_FILES['video']['name'])) {
                $upload_dir = "uploads/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $video_name = uniqid() . '_' . basename($_FILES["video"]["name"]);
                $video_path = $upload_dir . $video_name;
                
                if (move_uploaded_file($_FILES["video"]["tmp_name"], $video_path)) {
                    $content = '/' . $video_path;
                }
            }
        }

        $course = new Course(
            null,
            $body['title'],
            $body['description'],
            $content,
            $body['content_type'],
            $thumbnail,
            $_SESSION['user']['id'],
            $body['category_name']
        );
        
        if ($course->save()) {
            header('Location: /teacher/courses');
            exit;
        }
    }
    public function modify($request){
        $id = $request->getBody()['id'];
        $course = Course::getById($id);
        $courseTags = $course->getTags();
        $categories = Category::getAll();
        $tags = Tag::getAll();
      
        return $this->render('teacher-modify',[
            'course' => $course,
            'tags'=> $tags,
            'courseTags' => $courseTags,
            'categories'=> $categories,
        ]);
    }
    public function addTags($request){

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['tags']) || !isset($data['course_id']) || !is_array($data['tags'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
            return;
        }

        $tags = array_unique($data['tags']);
        $course_id = $data['course_id'];

        try {
            foreach ($tags as $tagName) {
                $tag = Tag::getByName($tagName);
                $tag->tagCourse($course_id);
            }
            echo json_encode(['status' => 'success']);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function removeTag($request){
        if(!isset($request->getBody()['tag']) || !isset($request->getBody()['course_id'])){
            header('Location: /404');
            exit;
        }
        $tag_name = $request->getBody()['tag'];
        $course_id = $request->getBody()['course_id'];
        $course = Course::getById($course_id);
        $course->removeTag($tag_name);
        header('Location: /teacher/modify?id='.$course_id);
    }
    public function changeTitle($request){
        var_dump($request->getBody());
        if(!isset($request->getBody()['title']) || !isset($request->getBody()['course_id']))
         {
            header('Location: /404');
            exit;
         }
         $title = $request->getBody()['title'];
         $course_id = $request->getBody()['course_id'];
         $course = Course::getById($course_id);
         $course->setTitle($title);
         $course->update();
         $_SESSION['message'] = 'Modified successfully';
         header('Location: /teacher/modify?id='.$course_id);
    }
    public function changeDescription($request){
        if(!isset($request->getBody()['description']) || !isset($request->getBody()['course_id']))
        {
           header('Location: /404');
           exit;
        }

        $description = $request->getBody()['description'];
        $course_id = $request->getBody()['course_id'];
        $course = Course::getById($course_id);
        $course->setDescription($description);
        $course->update();
        $_SESSION['message'] = 'Modified successfully';
        header('Location: /teacher/modify?id='.$course_id);

    }
    public function changeCategory($request){
        if(!isset($request->getBody()['category']) || !isset($request->getBody()['course_id']))
        {
           header('Location: /404');
           exit;
        }
        $category = $request->getBody()['category'];
        $course_id = $request->getBody()['course_id'];
        $course = Course::getById($course_id);
        $course->setCategoryName($category);
        $course->update();
        $_SESSION['message'] = 'Modified successfully';
        header('Location: /teacher/modify?id='.$course_id);
    }
    public function deleteCourse($request){
        if(!isset($request->getBody()['course_id'])){
            header('Location: /404');
            exit;
        }
        $course = Course::getById($request->getBody()['course_id']);
        $course->delete();
        $_SESSION['message'] = 'Deleted successfully';
        header('Location: /teacher/courses');
    }
}
