<?php

namespace app\models;

use app\core\Application;

class User {
    private  $id = null;
    private  $username;
    private  $email;
    private  $password = '';
    private $role = 'student';
    private $isactive = true;

    public function __construct($email,$password,$username,$id=null,$role='student',$isactive=true) {
        $this->setId($id ?? null);
        $this->setUsername($username ?? null);
        $this->setEmail($email ?? null);
        $this->setPassword($password ?? null);
        $this->setRole($role ?? null);
        $this->setIsactive($isactive ?? false);
    }
    public function getId(){
        return $this->id;
    }
    public function getusername(){
        return $this->username;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getRole(){
        return $this->role;
    }
    public function getIsactive(){
        return $this->isactive;
    }
    public function setId($id){
         $this->id = $id;
    }
    public function setusername($username){
         $this->username = $username;
    }
    public function setEmail($email){
         $this->email = $email;
    }
    public function setPassword($password){
         $this->password = $password;
    }
    public function setRole($role){
         $this->role = $role;
    }
    public function setIsactive($isactive){
        $this->isactive = $isactive;
    }
    public static function getAll(){
        $allUsers = Application::$app->db->query("select * from users")->getAll();
        return $allUsers;
    }
    public static function validateLogin($email,$password) {
        $errors = [];
        if (empty($email)) {
            $errors['email_error'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password_error'] = "Password is required.";
        } 
        elseif (strlen($password) < 4) {
            $errors['password_error'] = "Password must be at least 4 characters long.";
        }
        if (!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }
    public static function validateRegister($email,$password,$confirm_password,$username) {
        $errors = [];
        if (empty($email)) {
            $errors['email_error'] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = "Invalid email format.";
        }
        if (empty($password)) {
            $errors['password_error'] = "Password is required.";
        }
        elseif (strlen($password) < 4) {
            $errors['password_error'] = "Password must be at least 4 characters long.";
        }if ($password !== $confirm_password) {
            $errors['confirm_error'] = "Passwords do not match.";
        } 
        if(empty($username)) {
            $errors['username_error'] = "Username is required.";
        } elseif(strlen($username) < 4){
            $errors['username_error'] = "Username must be at least 4 characters long.";
        }
        if (!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }
    
    public static function findByEmail($email) {
        $user = Application::$app->db->query("SELECT id,email,password,username,role,isactive FROM users WHERE email = ?",[$email])->getOne();
        if (empty($user)) {
            return false;
        }else {
            return new self($user["email"], $user["password"], $user["username"],$user['id'], $user["role"], $user["isactive"]);
        }
    }
    public function checkPassword($password) {
        return password_verify($password,$this->password);
    }
    public function save() {
        $id = Application::$app->db->query("INSERT INTO users (username , email, password, role, isactive) 
             VALUES (?,?,?,?,?) RETURNING id",[$this->username,$this->email,$this->password,$this->role,$this->isactive])->getOne()['id'];
        $this->id = $id;
        return true;
    }
    public function update() {
        Application::$app->db->query("UPDATE users SET username = ? , email = ?, password = ?, role = ?, isactive = ? WHERE id = ?",[$this->username,$this->email,$this->password,$this->role,$this->isactive,$this->id]);
        return true;
    }
    public function delete(){
        Application::$app->db->query("DELETE FROM users where id = ?",[ $this->id ]);
        return true;
    }
}
