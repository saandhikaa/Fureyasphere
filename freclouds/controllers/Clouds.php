<?php
    class Clouds extends Controller {
        private $app = "freclouds";
        
        public function index() {
            $this->view($this->app, "clouds/index");
        }
    }
?>