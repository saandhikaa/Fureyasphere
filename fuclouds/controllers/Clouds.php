<?php
    class Clouds extends Controller {
        private $app = "fuclouds";
        private $data = [];
        private $table = "uploads";
        
        public function __construct() {
            $this->model($this->app, "FileHandler")->autoRemove();
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
        
        public function result() {
            $this->model($this->app, "FileHandler")->upload();
            die;
        }
        
        public function setup() {
            $this->model("shared", "TableMaster")->createTable($this->table);
            
            $this->data["title"] = "Setup";
            $this->data["table"] = $this->model("shared", "TableMaster")->getTableStructure($this->table);
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/setup", $this->data);
            $this->view("shared", "templates/footer");
        }
    }
?>