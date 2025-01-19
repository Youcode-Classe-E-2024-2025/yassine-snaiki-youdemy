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
    private $category_name;

    public function __construct($id = null, $title, $description, $content, $content_type, $thumbnail, $teacher_id, $category_name) {
        $this->setId($id );
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setContent($content);
        $this->setContentType($content_type);
        $this->setThumbnail($thumbnail);
        $this->setTeacherId($teacher_id);
        $this->setCategoryName($category_name);
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
    public function getUsername(){
        return Application::$app->db->query('select username from users where id = ?',[$this->teacher_id])->getOne()['username'];
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

    public static function getFeatured(){
        $coursesAssoc = Application::$app->db->query('select c.*,count(e.student_id) as count from courses c join users u on c.teacher_id = u.id join enrollments e on c.id = e.course_id group by c.id order by count desc limit 6')->getAll();
        $courses = [];
        foreach ($coursesAssoc as $course) {
            $courses[]= new self($course['id'], $course['title'], $course['description'], $course['content'],$course['content_type'],$course['thumbnail'], $course['teacher_id'], $course['category_name']);
        }
        return $courses;
    }

    public function isEnrolled($user_id) {
        $isEnrolled = Application::$app->db->query(' select * from enrollments where course_id = ? and student_id = ?', [$this->id,$user_id])->getOne();
        return $isEnrolled !== false;
    }
    public static function getPaginated($limit,$offset){
        $coursesAssoc = Application::$app->db->query("select * from courses limit ? offset ?",[$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name']);
        }
        return $courses;
    }
    public static function getCategoryPaginated($cg,$limit,$offset){
        $coursesAssoc = Application::$app->db->query("select * from courses where category_name = ? limit ? offset ?",[$cg,$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name']);
        }
        return $courses;
    }
    public static function getSearchPaginated($sh,$limit,$offset){
        $coursesAssoc = Application::$app->db->query("select * from courses where vector @@ plainto_tsquery('english',?) limit ? offset ?",[$sh,$limit,$offset])->getAll();
        $courses=[];
        foreach($coursesAssoc as $course){
            $courses[] = new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name']);
        }
        return $courses;
    }
    public static function mostEnrolled(){
        $courseAssoc = Application::$app->db->query('select c.*,count(e.student_id) as enroll_count from courses c join enrollments e on c.id = e.course_id group by c.id order by enroll_count desc limit 1')->getOne();
        $course = new self($courseAssoc['id'],$courseAssoc['title'],$courseAssoc['description'],$courseAssoc['content'],$courseAssoc['content_type'],$courseAssoc['thumbnail'],$courseAssoc['teacher_id'],$courseAssoc['category_name']);
        return $course;
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
    public static function getById($id){
        $course = Application::$app->db->query('select * from courses  where id = ?',[$id])->getOne();
        if($course)
        return new self($course['id'],$course['title'],$course['description'],$course['content'],$course['content_type'],$course['thumbnail'],$course['teacher_id'],$course['category_name']);
        return false;
    }
    public function getTags(){
        $tagsAssoc = Application::$app->db->query('select tag_name from course_tags   where course_id = ?',[$this->id])->getAll();
        $tags = [];
        foreach($tagsAssoc as $tag){
            $tags[] = new Tag($tag['tag_name']);
        }
        return $tags;
    }
    public function removeTag($name){
        Application::$app->db->query('delete from course_tags where course_id = ? and tag_name = ?',[$this->id,$name]);
        return true;
    }

    public function save() {
        if($this->thumbnail !== null)
        $id = Application::$app->db->query("INSERT INTO courses (title, description, content,content_type,thumbnail, teacher_id, category_name) 
            VALUES (?, ?, ?, ?, ?,?,?) RETURNING id", [$this->title, $this->description, $this->content,$this->content_type,$this->thumbnail, $this->teacher_id, $this->category_name])->getOne()['id'];
        else Application::$app->db->query("INSERT INTO courses (title, description, content,content_type, teacher_id, category_name) 
            VALUES (?, ?, ?, ?, ?,?) RETURNING id", [$this->title, $this->description, $this->content,$this->content_type, $this->teacher_id, $this->category_name])->getOne()['id'];
        $this->id = $id;
        return true;
    }
    public function update() {
        Application::$app->db->query("update courses set title = ?, description = ?  , category_name = ? where id = ?", [$this->title, $this->description, $this->category_name,$this->id])->getOne()['id']; 
        return true;
    }
    public function delete() {
        Application::$app->db->query("delete from courses  where id = ?", [$this->id])->getOne()['id']; 
        return true;
    }
}