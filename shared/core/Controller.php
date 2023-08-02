<?php
    class Controller {
        public function view ($app, $view, $data = array()) {
            require_once __DIR__ . "/../../" . $app . "/views/" . $view . ".php";
        }
        
        public function model ($app, $model) {
            require_once __DIR__ . "/../../" . $app . "/models/" . $model . ".php";
            return new $model;
        }
    }
?>