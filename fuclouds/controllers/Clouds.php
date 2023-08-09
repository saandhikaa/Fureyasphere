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
            $this->view("shared", "templates/footer", $this->data);
        }
        
        public function upload() {
            $this->data["title"] = ucwords($this->app) . ": Upload";
            $this->data["appScript"] .= '<script type="text/javascript">createInput(true);</script>';
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/upload");
            $this->view("shared", "templates/footer", $this->data);
        }
        
        public function result ($codename = null, $key = null) {
            if (isset($_POST["token"])) {
                if ($_POST["token"] === UP_TOKEN) {
                    $this->data["result"] = $this->model($this->app, "FileHandler")->upload();
                } elseif ($_POST["token"] === SR_TOKEN) {
                    $this->data["result"]["files"] = $this->model($this->app, "FileHandler")->loadFiles($_POST["codename"], $_POST["key"]);
                } elseif ($_POST["token"] === DL_TOKEN) {
                    $this->model($this->app, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
                }
            } elseif (!is_null($codename)  && !is_null($key)) {
                $this->data["result"]["files"] = $this->model($this->app, "FileHandler")->loadFiles($codename, $key);
            } else {
                $this->index();
                exit();
            }
            
            $this->data["title"] = "Result";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/result", $this->data);
            $this->view("shared", "templates/header");
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