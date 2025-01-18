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
    public static function getAll(){
        $categoriesAssoc = Application::$app->db->query("select * from categories")->getAll();
        $categories = [];
        foreach ($categoriesAssoc as $category) {
            $categories[] = new self($category["name"]);
        }
        return $categories;
    }
    public static function getUsedCategories(){
        $categoriesAssoc = Application::$app->db->query("select distinct c.* from categories c join courses cr on c.name = cr.category_name")->getAll();
        $categories = [];
        foreach ($categoriesAssoc as $category) {
            $categories[] = new self($category["name"]);
        }
        return $categories;
    }
}