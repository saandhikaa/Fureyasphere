<?php
    class App {
        protected $controller = 'Home';
        protected $method = 'index';
        protected $params = array();
        protected $controllerDir = [__DIR__ . "/../controllers/"];
        
        public function __construct() {
            $url = $this->parseURL();
            
            foreach (self::getAppList() as $app) {
                $this->controllerDir[] = __DIR__ . "/../../" . $app["dir"][0] . "/controllers/";
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
                $url[0] = ucfirst(strtolower($url[0]));
                return $url;
            }
        }
        
        public static function getAppList($shared = false) {
            $result = [];
            
            foreach (glob(__DIR__ . '/../../*', GLOB_ONLYDIR) as $app) {
                $appDir = basename($app);
                $controllers = [];
                
                if ($appDir !== "shared" || $shared) {
                    foreach (glob($app . '/controllers/*.php') as $controllerFile) {
                        $controllers[] = basename($controllerFile, '.php');
                    }
                    
                    if ($appDir == "shared") {
                        $result[0]["dir"][0] = $appDir;
                        $result[0]["dir"][1] = self::title($appDir);
                        $result[0]["class"] = $controllers;
                    } else {
                        preg_match('/-(\d+)/', $appDir, $matches);
                        $result[$matches[1]]["dir"][0] = $appDir;
                        $result[$matches[1]]["dir"][1] = self::title($appDir);
                        $result[$matches[1]]["class"] = $controllers;
                    }
                }
            }
            
            ksort($result);
            return $result;
            // array(
            //     [index of the end app dir/] => array(
            //         "dir" => array(
            //             [0] => "app dir/",
            //             [1] => "clean app dir/"
            //         ),
            //         "class" => array(
            //             [0] => "app class",
            //             ...
            //         )
            //     )...
            // )
        }
        
        public static function title($string) {
            $parts = explode('-', $string);
            $parts = array_map('ucfirst', $parts);
            if (is_numeric(end($parts))) {
                array_pop($parts);
            }
            return implode(' ', $parts);
        }
    }
?>