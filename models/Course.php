<?php

namespace app\models;

use app\core\Application;

class Course {
    private $id;
    private $title;
    private $description;
    private $content;
    private $content_type;
    private $thumbnail;
    private $teacher_id;
    private $username;
    private $category_name;

    public function __construct($id = null, $title, $description, $content, $content_type, $thumbnail, $teacher_id, $category_name,$username) {
        $this->setId($id );
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setContent($content);
        $this->setContentType($content_type);
        $this->setThumbnail($thumbnail);
        $this->setTeacherId($teacher_id);
        $this->setCategoryName($category_name);
        $this->setUsername($username);
    }

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getContent() {
        return $this->content;
    }
    public function getContentType() {
        return $this->content_type;
    }
    public function getThumbnail() {
        return $this->thumbnail;
    }
    public function setContentType($content_type) {
        $this->content_type = $content_type;
    }
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getTeacherId() {
        return $this->teacher_id;
    }

    public function setTeacherId($teacher_id) {
        $this->teacher_id = $teacher_id;
    }

    public function getCategoryName() {
        return $this->category_name;
    }

    public function setCategoryName($category_name) {
        $this->category_name = $category_name;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public static function getFeatured(){
        $coursesAssoc = Application::$app->db->query('select c.*,u.username as username,count(e.student_id) as count from courses c join users u on c.teacher_id = u.id join enrollments e on c.id = e.course_id group by c.id,username order by count desc limit 6')->getAll();
        $courses = [];
        foreach ($coursesAssoc as $course) {
            $courses[]= new self($course['id'], $course['title'], $course['description'], $course['content'],$course['content_type'],$course['thumbnail'], $course['teacher_id'], $course['category_name'],$course['username']);
        }
        return $courses;
    }


    public static function getPaginated($limit,$offset){
        $coursesAssoc = Application::$app->db->query("select c.*,u.username from courses c join users u on c.teacher_id = u.id limit ? offset ?",[$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name'],$course['username']);
        }
        return $courses;
    }
    public static function getCategoryPaginated($cg,$limit,$offset){
        $coursesAssoc = Application::$app->db->query("select c.*,u.username from courses c join users u on c.teacher_id = u.id where c.category_name = ? limit ? offset ?",[$cg,$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name'],$course['username']);
        }
        return $courses;
    }
    public static function getSearchPaginated($sh,$limit,$offset){
        $coursesAssoc = Application::$app->db->query("select c.*,u.username from courses c join users u on c.teacher_id = u.id where c.vector @@ plainto_tsquery('english',?) limit ? offset ?",[$sh,$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name'],$course['username']);
        }
        return $courses;
    }
    public static function count(){
        $count = Application::$app->db->query("select count(*) from courses")->getOne()['count'];
        return $count;
    }
    public static function countInCategory($cg){
        $count = Application::$app->db->query("select count(*) from courses where category_name = ?",[$cg])->getOne()['count'];
        return $count;
    }
    public static function countInSearch($sh){
        $count = Application::$app->db->query("select count(*) from courses where vector @@ plainto_tsquery('english',?)",[$sh])->getOne()['count'];
        return $count;
    }

    public function save() {
        $id = Application::$app->db->query("INSERT INTO courses (title, description, content, teacher_id, category_name) 
            VALUES (?, ?, ?, ?, ?) RETURNING id", [$this->title, $this->description, $this->content, $this->teacher_id, $this->category_name])->getOne()['id'];
        $this->id = $id;
        return true;
    }
}