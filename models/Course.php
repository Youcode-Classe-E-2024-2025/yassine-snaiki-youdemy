<?php

namespace app\models;

use app\core\Application;

class Course {
    private $id;
    private $title;
    private $description;
    private $content;
    private $teacher_id;
    private $category_name;

    public function __construct($id = null, $title, $description, $content, $teacher_id, $category_name) {
        $this->setId($id );
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setContent($content);
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

    public function save() {
        $id = Application::$app->db->query("INSERT INTO courses (title, description, content, teacher_id, category_name) 
            VALUES (?, ?, ?, ?, ?) RETURNING id", [$this->title, $this->description, $this->content, $this->teacher_id, $this->category_name])->getOne()['id'];
        $this->id = $id;
        return true;
    }
}