<?php
    class Controller {
        protected $database;
        
        public function view ($app, $view, $data = []) {
            require_once __DIR__ . "/../../" . $app . "/views/" . $view . ".php";
        }
        
        public function model ($app, $model) {
            require_once __DIR__ . "/../../" . $app . "/models/" . $model . ".php";
            return new $model($this->database);
        }
    }
?>