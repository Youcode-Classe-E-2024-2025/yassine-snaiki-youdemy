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
    public function getAll() {
        $tagsAssoc = Application::$app->db->query("select * from tags")->getAll();
        $tags = [];
        foreach ($tagsAssoc as $tag) {
            $tags[] = new self($tag["name"]);
        }
        return $tags;
    }
    public function save() {
        Application::$app->db->query("INSERT INTO tags (name) VALUES (?)", [$this->name]);
        return true;
    }
}