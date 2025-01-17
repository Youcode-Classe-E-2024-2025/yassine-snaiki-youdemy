<?php

namespace app\core;

class Router {
    private $routes = [];
    private $request;
    public function __construct($request){
        $this->request = $request;
    }
    public function get($path,$callback){
        $this->routes['get'][$path]=$callback;
    }
    public function post($path,$callback){
        $this->routes['post'][$path]=$callback;
    }
    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if(!$callback) {
            http_response_code(404);
            return $this->renderContent("<H1>not found 404</H1>");
        }
        if(is_string($callback)) 
        return $this->renderView($callback);
        if(is_array($callback)) {
            $callback[0] = new $callback[0]($this->request);
            return call_user_func($callback,$this->request);
        }
        return call_user_func($callback);
    }
    public function renderView($view,$params=[]){
        $viewContent = $this->renderOnlyView($view, $params);
        return $this->renderContent($viewContent);
    }
    private function renderContent($content) {
        $role = $this->request->getRole();
        $layoutContent = $this->renderLayout("{$role}-layout");
        return str_replace('{{content}}', $content, $layoutContent);
    }
    private function renderLayout($layout){
        ob_start();
        include Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }
    private function renderOnlyView($view, $params=[]){
        foreach($params as $key=>$value){
            $$key = $value;
        }
        ob_start();
        include Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}