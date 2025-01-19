<?php

namespace app\models;

use app\core\Application;

class TeachingRequest {
    private $id;
    private $user_id;
    public function __construct($id=null,$user_id) {
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
    public function getUsername() {
        $username = Application::$app->db->query("select username from users where id = ?", [$this->user_id])->getOne();
        return $username["username"];
    }
    public function getEmail() {
        $email = Application::$app->db->query("select email from users where id = ?", [$this->user_id])->getOne();
        return $email['email'];
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
        $user = User::findById($this->user_id);
    
        if ($user) {
            $user->setRole('teacher');
            $user->update();
            $this->delete();
            return true;
        }
    }
    public static function getPaginated($limit,$offset){
        $requestsAssoc = Application::$app->db->query("select * from teaching_requests limit ? offset ?",[$limit,$offset])->getAll();
        $requests=[];
        foreach($requestsAssoc as $request){
            $requests[] = new self($request['id'],$request['user_id']);
        }
        return $requests;
    }
    public static function findById($id) {
        $reqAssoc = Application::$app->db->query('select * from teaching_requests where id= ?',[$id])->getOne();
        if($reqAssoc){
            return new self($reqAssoc['id'],$reqAssoc['user_id']);
        } return false;
    }
    public static function count(){
        $count = Application::$app->db->query("select count(*) from teaching_requests")->getOne()['count'];
        return $count;
    }
}