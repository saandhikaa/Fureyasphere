<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = array();
        protected $controllerDir = [__DIR__ . "/../controllers/"];
    
        public function __construct() {
            $url = $this->parseURL();
            
            foreach (array_keys(self::getAppList()) as $app) {
                $this->controllerDir[] = __DIR__ . "/../../" . $app . "/controllers/";
            }
            
            // get controller from url
            if (!empty($url)) {
                foreach ($this->controllerDir as $dir) {
                    if (file_exists($dir . $url[0] . ".php")) {
                        $this->controller = $url[0];
                        $this->controllerDir = [$dir];
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
        
        // getting all app directory path
        public static function getAppList() {
            $appList = [];
            
            foreach (glob(__DIR__ . '/../../*', GLOB_ONLYDIR) as $app) {
                $appName = basename($app);
                $controllers = [];
                
                if ($appName !== "shared") {
                    foreach (glob($app . '/controllers/*.php') as $controllerFile) {
                        $controllers[] = basename($controllerFile, '.php');
                    }
                    $appList[$appName] = $controllers;
                }
            }
            
            return $appList;
        }
        
        public static function getAppListNavigation() {
            $apps = self::getAppList();
            $result = [];
            
            foreach ($apps as $key => $app) {
                preg_match('/-(\d+)/', $key, $matches);
                $newKey = $matches[1];
                $result[$newKey] = $app;
            }
            
            ksort($result);
            return $result;
        }
    }
?>