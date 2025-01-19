<?php

namespace app\models;

use app\core\Application;

class Tag {
    private $name;

    public function __construct($name) {
        $this->setName($name);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }
    public static function getAll() {
        $tagsAssoc = Application::$app->db->query("select * from tags")->getAll();
        $tags = [];
        foreach ($tagsAssoc as $tag) {
            $tags[] = new self($tag["name"]);
        }
        return $tags;
    }
    public static function getByName($name) {
        $tagAssoc = Application::$app->db->query('SELECT * FROM tags WHERE name = ?', [$name])->getOne();
        return new self($tagAssoc['name']);
    }
    public function save() {
        Application::$app->db->query("INSERT INTO tags (name) VALUES (?)", [$this->name]);
        return true;
    }
    public function delete() {
        Application::$app->db->query("delete from tags where name = ?", [$this->name]);
        return true;
    }
    public function tagCourse($course_id){
        Application::$app->db->query("insert into course_tags(course_id,tag_name) values(?,?) on conflict do nothing", [$course_id, $this->name]);
        return true;
    }
}