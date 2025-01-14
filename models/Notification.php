<?php

namespace app\models;

use app\core\Application;

class Notification {
    private $id;
    private $user_id;
    private $message;
    private $is_read;

    public function __construct($id = null, $user_id, $message, $is_read = false) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setMessage($message);
        $this->setIsRead($is_read);
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getIsRead() {
        return $this->is_read;
    }

    public function setIsRead($is_read) {
        $this->is_read = $is_read;
    }
    public function save() {
        $id = Application::$app->db->query("INSERT INTO notifications (user_id, message) 
            VALUES (?, ?) RETURNING id", [$this->user_id, $this->message])->getOne()['id'];
        $this->id = $id;
        return true;
    }
}