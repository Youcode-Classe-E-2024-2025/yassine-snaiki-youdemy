<?php

namespace app\models;

use app\core\Application;

class TeachingRequest {
    private $id;
    private $user_id;
    public function __construct($user_id,$id=null) {
        $this->setId($id);
        $this->setUserId($user_id);
    }   
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
    public function save() {
        $this->id = Application::$app->db->query("INSERT INTO teaching_requests (user_id) VALUES (?) RETURNING id", [$this->user_id])->getOne()['id'];
        return true;
    }
    public function delete() {
        Application::$app->db->query("DELETE FROM teaching_requests WHERE id = ?", [$this->id]);
        return true;
    }
    public function accept(){
        $user = User::findByEmail($this->user_id);
        if ($user) {
            $user->setRole('teacher');
            $user->update();
            $this->delete();
            return true;
        }
    }
}