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
            $this->data["appScript"] .= '<script type="text/javascript">createInput();</script>';
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/upload");
            $this->view("shared", "templates/footer", $this->data);
        }
        
        public function result ($codename = null, $key = null, $status = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if ($_POST["submit"] === "Upload") {
                    $result = $this->model($this->app, "FileHandler")->upload() . "/uploaded";
                } elseif ($_POST["submit"] === "Search") {
                    $result = $_POST["keyword"];
                } elseif ($_POST["submit"] === "Download" || $_POST["submit"] === "Download All as Zip") {
                    $this->model($this->app, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
                    $result = $_POST["codename"] . "/" . $_POST["key"];
                }
                header("Location: " . BASEURL . "/Clouds/result/" . $result);
                exit;
            } elseif (is_null($codename) || is_null($key)) {
                header("Location: " . BASEURL . "/Clouds");
                exit;
            }
            
            $this->data["title"] = ucwords($this->app) . ": Result";
            $this->data["result"] = $this->model($this->app, "FileHandler")->loadFiles($codename, $key);
            $this->data["status"] = $status;
            $this->data["keyword"] = $codename . "/" . $key;
            
            $this->view("shared", "templates/header", $this->data);
            $this->view($this->app, "clouds/result", $this->data);
            $this->view("shared", "templates/footer");
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