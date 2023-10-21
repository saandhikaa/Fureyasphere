<?php
    class Controller {
        protected $database;
        
        public function view ($page, $data = []) {
            $content = __DIR__ . "/../../{$data['dir']}/views/{$data['class']}/$page.php";
            require_once __DIR__ . "/../views/layout/main.php";
        }
        
        public function model ($app, $model) {
            require_once __DIR__ . "/../../" . $app . "/models/" . $model . ".php";
            return new $model($this->database);
        }
    }
?>