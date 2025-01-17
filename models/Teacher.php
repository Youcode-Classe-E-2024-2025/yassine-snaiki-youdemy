<?php

namespace app\models;

use app\core\Application;

class Teacher extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($id, $email, $password, $username, 'teacher', $isactive);
    }

    public static function getAll(){
        $allUsers = Application::$app->db->query("select * from users where role = 'teacher'")->getAll();
        $users=[];
        foreach($allUsers as $user){
            $users[] = new self($user['email'],$user['password'],$user['username'],$user['id'],$user['isactive']);
        }
        return $users;
    }
    public static function getPaginated($limit,$offset){
        $usersAssoc = Application::$app->db->query("select * from users where isactive = true and role = 'teacher' limit ? offset ?",[$limit,$offset])->getAll();
        $users=[];
        foreach($usersAssoc as $user){
            $users[] = new self($user['email'],$user['password'],$user['username'],$user['id'],$user['isactive']);
        }
        return $users;
    }
    public static function count(){
        $count = Application::$app->db->query("select count(*) from users where isactive = true and role = 'teacher'")->getOne()['count'];
        return $count;
    }

    public function createCourse($title, $description, $content, $category_name) {
        // Logic to create a course
        // Assuming there's a Course model
        $course = new Course();
        $course->setTitle($title);
        $course->setDescription($description);
        $course->setContent($content);
        $course->setTeacherId($this->getId());
        $course->setCategoryName($category_name);
        return $course->save();
    }

    public function manageCourse($course_id, $action) {
        // Logic to manage courses (update, delete, view enrollments)
    }
}