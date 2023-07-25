<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = array();
        protected $controllerDir = array(__DIR__ . "/../controllers/");
    
        public function __construct() {
            $url = $this->parseURL();
            
            // get controller from url
            if (!empty($url)) {
                if (file_exists($this->controllerDir[0] . $url[0] . ".php")) {
                    $this->controller = $url[0];
                    unset($url[0]);
                }
            }
            
            // create instance controller
            require_once $this->controllerDir[0] . $this->controller . ".php";
            $this->controller = new $this->controller;
            
            // get method from url
            if (isset($url[1]) && !isset($url[0])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    unset($url[1]);
                }
            }
            
        }
        
        public function parseURL() {
            if (isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }
?>