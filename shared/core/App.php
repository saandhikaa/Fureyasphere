<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = array();
        protected $controllerDir = array(__DIR__ . "/../controllers/");
    
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