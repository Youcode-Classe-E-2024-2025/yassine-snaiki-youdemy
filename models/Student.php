<?php

namespace app\models;

use app\core\Application;

class Student extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($id, $email, $password, $username, 'student', $isactive);
    }

    public function enroll($course_id) {
        Application::$app->db->query("INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)", [$this->getId(), $course_id]);
    }

    public function getEnrolledCourses() {
        $courses = Application::$app->db->query("SELECT c.* FROM courses c JOIN enrollments e ON c.id = e.course_id WHERE e.student_id = ?", [$this->getId()])->getAll();
        return $courses;
    }

    
}