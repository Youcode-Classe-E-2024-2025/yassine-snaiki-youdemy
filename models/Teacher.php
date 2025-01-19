<?php

namespace app\models;

use app\core\Application;

class Teacher extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($email, $password, $username, $id, 'teacher', $isactive);
    }

    public static function getAll(){
        $allUsers = Application::$app->db->query("select * from users where role = 'teacher'")->getAll();
        $users=[];
        foreach($allUsers as $user){
            $users[] = new self($user['id'], $user['email'], $user['password'], $user['username'], $user['isactive']);
        }
        return $users;
    }
    public static function getPaginated($limit,$offset){
        $usersAssoc = Application::$app->db->query("select * from users where isactive = true and role = 'teacher' limit ? offset ?",[$limit,$offset])->getAll();
        $users=[];
        foreach($usersAssoc as $user){
            $users[] = new self($user['id'], $user['email'], $user['password'], $user['username'], $user['isactive']);
        }
        return $users;
    }
    public static function count(){
        $count = Application::$app->db->query("select count(*) from users where isactive = true and role = 'teacher'")->getOne()['count'];
        return $count;
    }

    public function createCourse($title, $description, $content, $category_name) {
      
        $course = new Course();
        $course->setTitle($title);
        $course->setDescription($description);
        $course->setContent($content);
        $course->setCategoryName($category_name);
        return $course;
    }

    public function manageCourse($course_id, $action) {
        
    }
    public static function top3(){
        $teachersAssoc = Application::$app->db->query("
        with course_enrollments as (
            select c.teacher_id,count(e.student_id) as count from courses c join enrollments e on c.id = e.course_id group by c.teacher_id
        )
        select t.*,avg(ce.count) from users t join course_enrollments ce on t.id = ce.teacher_id where t.role = 'teacher' and t.isactive = true group by t.id order by avg(ce.count) desc limit 3
        ")->getAll();
        $teachers = [];
        foreach($teachersAssoc as $teacher){
            $teachers[] = new self($teacher['id'], $teacher['email'], $teacher['password'], $teacher['username'], $teacher['isactive']);
        }
        return $teachers;
    }
    public function courseCount(){
        $count = Application::$app->db->query("select count(*) from courses where teacher_id = ?",[$this->getId()])->getOne()['count'];
        return $count;
    }
    public function getCourses(){
        $coursesAssoc = Application::$app->db->query("select * from courses where teacher_id = ?",[$this->getId()])->getAll();
        $courses = [];
        foreach($coursesAssoc as $course){
            $courses[] = new Course($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name']);
        }
        return $courses;
    }
}