<?php
    class Fuclouds extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["mainApp"] = "shared";
            $this->data["app"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/app.css">' . PHP_EOL;
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/app.js"></script>' . PHP_EOL;
            $this->data["image-path"] = '<p class="image-path">' . BASEURL . '/' . $this->app . '/assets/images/</p>' . PHP_EOL;
            
            try {
                $this->model($this->app, "FileHandler")->autoRemove();
            } catch (PDOException $e) {
                echo '<p class="database-error">' . $e->getMessage() . '</p>';
            }
        }
        
        public function index() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $_POST["keyword"];
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Search";
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/index", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function upload() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $this->model($this->app, "FileHandler")->upload() . "/uploaded";
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Upload";
            $this->data["appScript"] .= '<script type="text/javascript">createInput();</script>' . PHP_EOL;
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/upload", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function result ($codename = null, $key = null, $action = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $this->model($this->app, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Result";
            $this->data["result"] = $this->model($this->app, "FileHandler")->loadFiles($codename, $key);
            $this->data["action"] = $action;
            $this->data["keyword"] = "$codename/$key";
            $this->data["appScript"] .= '<script type="text/javascript">autorunResult();</script>' . PHP_EOL;
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/result", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
        
        public function setup() {
            $tableName = "uploads";
            
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if (isset($_POST["submit"]) && isset($_POST["table"])) {
                    $this->data["status"] = $this->model($this->data["mainApp"], "TableMaster")->createTable($tableName, $_POST["table"]);
                    $this->data["status"] .= $this->model($this->app, "FileHandler")->createUploadsDir();
                }
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Setup";
            $this->data["table"] = $this->model($this->data["mainApp"], "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->data["mainApp"], "templates/header", $this->data);
            $this->view($this->app, "$this->class/setup", $this->data);
            $this->view($this->data["mainApp"], "templates/footer", $this->data);
        }
    }
?>