<?php

namespace app\core;

class Application {
    public static $ROOT_DIR;
    public $router;
    public  $request;
    public static $app;
    public $db;

    public function __construct($rootDir){
        self::$app = $this;
        self::$ROOT_DIR = $rootDir;
        $this->request = new Request();
        $this->db = new Database();
        $this->router = new Router($this->request);
    }
    public function run(){
        echo $this->router->resolve();
    }
}