<?php

namespace app\models;

use app\core\Application;

class TeachingRequest {
    private $id;
    private $user_id;
    private $username;
    private $email;
    public function __construct($user_id,$id=null, $username=null, $email=null) {
        $this->setId($id);
        $this->setUserId($user_id);
        $this->setUsername($username);
        $this->setEmail($email);
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
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setUsername($username) {
        $this->username = $username;
    }
    public function setEmail($email) {
        $this->email = $email;
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
    public static function getPaginated($limit,$offset){
        $requestsAssoc = Application::$app->db->query("select u.id user_id, u.username username,u.email email ,tr.id  id from users u join teaching_requests tr on u.id = tr.user_id limit ? offset ?",[$limit,$offset])->getAll();
        $requests=[];
        foreach($requestsAssoc as $request){
            $requests[] = new self($request['user_id'],$request['id'],$request['username'],$request['email']);
        }
        return $requests;
    }
    public static function count(){
        $count = Application::$app->db->query("select count(*) from teaching_requests")->getOne()['count'];
        return $count;
    }
}