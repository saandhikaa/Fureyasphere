<?php
    class Clouds extends Controller {
        private $app = "fuclouds";
        
        public function index() {
            $data = array(
                "title" => ucwords($this->app) . ": Search"
            );
            
            $this->view("shared", "templates/header", $data);
            $this->view($this->app, "clouds/index");
            $this->view("shared", "templates/footer");
        }
        
        public function upload() {
            $data = array(
                "title" => ucwords($this->app) . ": Upload"
            );
            
            $this->view("shared", "templates/header", $data);
            $this->view($this->app, "clouds/upload");
            $this->view("shared", "templates/footer");
        }
    }
?>