<?php

namespace app\models;

class Teacher extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($id, $email, $password, $username, 'teacher', $isactive);
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