<?php
    class Clouds extends Controller {
        private $app = "fuclouds";
        private $data = [];
        
        public function __construct() {
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/app.js"></script>';
        }
        
        public function index() {
            $this->data["title"] = ucwords($this->app) . ": Search";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/index");
            $this->view("shared", "templates/footer");
        }
        
        public function upload() {
            $this->data["title"] = ucwords($this->app) . ": Upload";
            $this->data["runScript"] = '<script type="text/javascript">createInput(true);</script>';
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/upload");
            $this->view("shared", "templates/footer", $this->data);
        }
    }
?>