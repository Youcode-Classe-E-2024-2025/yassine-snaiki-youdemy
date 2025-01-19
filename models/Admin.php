<?php

namespace app\models;

use app\core\Application;

class Admin extends User {
    public function __construct($id = null, $email, $password, $username, $isactive = true) {
        parent::__construct($id, $email, $password, $username, 'admin', $isactive);
    }

    public function validateTeacherAccount($teacher_id) {
        Application::$app->db->query("UPDATE users SET role = 'teacher' WHERE id = ?", [$teacher_id]);
    }

 


}