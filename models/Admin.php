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

    public function manageUsers($user_id, $action) {
        // Logic to activate, suspend, or delete users
        if ($action === 'activate') {
            Application::$app->db->query("UPDATE users SET isactive = true WHERE id = ?", [$user_id]);
        } elseif ($action === 'suspend') {
            Application::$app->db->query("UPDATE users SET isactive = false WHERE id = ?", [$user_id]);
        } elseif ($action === 'delete') {
            Application::$app->db->query("DELETE FROM users WHERE id = ?", [$user_id]);
        }
    }

    public function manageContent($content_type, $content_id, $action) {
        // Logic to manage courses, categories, and tags
        // content_type can be 'course', 'category', 'tag'
    }

    public function getGlobalStatistics() {
        // Logic to retrieve global statistics
        // e.g., number of total courses, distribution by category, etc.
    }
}