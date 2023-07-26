<?php
    class Clouds extends Controller {
        private $app = "freclouds";
        
        public function index() {
            $data = array(
                "title" => ucwords($this->app)
            );
            
            $this->view("shared", "templates/header", $data);
            $this->view($this->app, "clouds/index");
            $this->view("shared", "templates/footer");
        }
    }
?>