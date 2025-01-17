<?php

namespace app\models;

use app\core\Application;

class Category {
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
    public function save() {
        Application::$app->db->query("INSERT INTO categories (name) VALUES (?)", [$this->name]);
        return true;
    }
    public function getAll(){
        $categoriesAssoc = Application::$app->db->query("select * from categories")->getAll();
        $categories = [];
        foreach ($categoriesAssoc as $category) {
            $categories[] = new self($category["name"]);
        }
        return $categories;
    }
}