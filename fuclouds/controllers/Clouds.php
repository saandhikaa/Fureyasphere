<?php
    class Clouds extends Controller {
        private $app = "fuclouds";
        private $data;
        
        public function index() {
            $this->data["title"] = ucwords($this->app) . ": Search";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/index");
            $this->view("shared", "templates/footer");
        }
        
        public function upload() {
            $this->data["title"] = ucwords($this->app) . ": Upload";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/upload");
            $this->view("shared", "templates/footer");
        }
    }
?>