<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = array();
        protected $controllerDir = array(__DIR__ . "/../controllers/");
    
        public function __construct() {
            $url = $this->parseURL();
            
            // getting all app controller directoryPath 
            foreach (glob(__DIR__ . '/../../*', GLOB_ONLYDIR) as $app) {
                if (basename($app) != "shared") {
                    $this->controllerDir[] = __DIR__ . "/../../" . basename($app) . "/controllers/";
                }
            }
            
            // get controller from url
            if (!empty($url)) {
                foreach ($this->controllerDir as $dir) {
                    if (file_exists($dir . $url[0] . ".php")) {
                        $this->controller = $url[0];
                        $this->controllerDir = array($dir);
                        unset($url[0]);
                        break;
                    }
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
            
            // get parameters from url
            if (isset($url[2]) && !isset($url[0]) && !isset($url[1])) {
                $this->params = array_values($url);
            }
            
            call_user_func_array([$this->controller, $this->method], $this->params);
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