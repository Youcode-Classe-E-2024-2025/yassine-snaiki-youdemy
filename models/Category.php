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
    public function delete() {
        Application::$app->db->query("update courses set category_name = 'not precised' where category_name = ?", [$this->name]);
        Application::$app->db->query("delete from categories where name = ?", [$this->name]);
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
    public function count(){
        $count = Application::$app->db->query("select count(*) from courses where category_name = ?", [$this->name])->getOne()['count'];
        return $count;    
    }
    public static function getByName($name){
        $category = Application::$app->db->query('SELECT * FROM categories WHERE name = ?', [$name])->getOne();
        return new self($category['name']);
    }
    public static function getUsedCategories(){
        $categoriesAssoc = Application::$app->db->query("select distinct c.* from categories c join courses cr on c.name = cr.category_name where c.name != 'not precised'")->getAll();
        $categories = [];
        foreach ($categoriesAssoc as $category) {
            $categories[] = new self($category["name"]);
        }
        return $categories;
    }
}