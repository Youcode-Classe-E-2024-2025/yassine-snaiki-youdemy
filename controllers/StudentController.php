<?php

namespace app\controllers;
use app\core\Controller;
use app\core\Request;
use app\models\Course;
use app\models\Category;
use app\models\Student;
use app\models\User;

class StudentController extends Controller
{

    public function __construct($request) {
        if ($request->getRole() !== 'student') {
            http_response_code(403);
            header('Location: /login');
            exit;
        }
    }
    public function enroll($request) {
        if($request->getRole()==='visitor' || !isset($_SESSION['user'])){
            if($request->getBody()["course_id"])
            $_SESSION['course_id'] = $request->getBody()["course_id"];
            header('Location: /login');
            exit;
        }
        if(!(isset($request->getBody()["course_id"]) && $request->getBody()["user_id"])){
            header('Location: /404');
            exit;
        }
        $userId = $request->getBody()["user_id"];
        $courseId = $request->getBody()["course_id"];
        $student = Student::findById($userId);
        if($student->enroll($courseId)){
            $_SESSION['success'] = "Enrolled successfully";
            header("Location: /course?id=$courseId");
            exit;
        }else  {
            $_SESSION["error"] = "Enrollment failed";
            header("Location: /course?id=$courseId");
            exit;
        }
    }

    public function myCourses($request) {
        if(!($request->getRole()=== "student")){
            header('Location: /');
            exit;
        }
        $studentId = $_SESSION['user']['id'];
        $student = Student::findById($studentId);
        $courses = $student->getCourses();
        return $this->render('mycourses',[
            'courses' => $courses,
        ]);
    }
    public function studyCourse($request) {
        if(!($request->getRole()=== 'student' && isset($request->getBody()['id']))){
            header('Location: /');
            exit;
        }
        $course = Course::getById($request->getBody()['id']);
        if(!$course->isEnrolled($_SESSION['user']['id'])){
            header('Location: /course?id='.$course->getId());
            exit;
        }
        $contentType = $course->getContentType();
        if($contentType === 'video'){
            return $this->render('study-video',[
                'course' => $course,
            ]);
        }

        return $this->render('study-document',[
            'course' => $course,
        ]);
    }
    
}