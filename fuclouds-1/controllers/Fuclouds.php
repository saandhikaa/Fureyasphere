<?php
    class Fuclouds extends Controller {
        private $appDir, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->appDir = basename(dirname(__DIR__));
            
            $this->data["mainAppDir"] = "shared";
            $this->data["class"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
            $this->data["appStyles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->appDir . '/assets/css/app.css">' . PHP_EOL;
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->appDir . '/assets/js/app.js"></script>' . PHP_EOL;
            $this->data["image-path"] = '<p class="image-path no-display">' . BASEURL . '/' . $this->appDir . '/assets/images/</p>' . PHP_EOL;
            
            try {
                $this->model($this->appDir, "FileHandler")->autoRemove();
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
            
            $this->view($this->data["mainAppDir"], "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/index", $this->data);
            $this->view($this->data["mainAppDir"], "templates/footer", $this->data);
        }
        
        public function upload() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $this->model($this->appDir, "FileHandler")->upload() . "/uploaded";
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Upload";
            $this->data["appScript"] .= '<script type="text/javascript">createInput();</script>' . PHP_EOL;
            
            $this->view($this->data["mainAppDir"], "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/upload", $this->data);
            $this->view($this->data["mainAppDir"], "templates/footer", $this->data);
        }
        
        public function result ($codename = null, $key = null, $action = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $this->model($this->appDir, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Result";
            $this->data["result"] = $this->model($this->appDir, "FileHandler")->loadFiles($codename, $key);
            $this->data["action"] = $action;
            $this->data["keyword"] = "$codename/$key";
            $this->data["appScript"] .= '<script type="text/javascript">autorunResult();</script>' . PHP_EOL;
            
            $this->view($this->data["mainAppDir"], "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/result", $this->data);
            $this->view($this->data["mainAppDir"], "templates/footer", $this->data);
        }
        
        public function setup() {
            $tableName = "uploads";
            
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if (isset($_POST["submit"]) && isset($_POST["table"])) {
                    $this->data["status"] = $this->model($this->data["mainAppDir"], "TableMaster")->createTable($tableName, $_POST["table"]);
                    $this->data["status"] .= $this->model($this->appDir, "FileHandler")->createUploadsDir();
                }
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Setup";
            $this->data["table"] = $this->model($this->data["mainAppDir"], "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->data["mainAppDir"], "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/setup", $this->data);
            $this->view($this->data["mainAppDir"], "templates/footer", $this->data);
        }
    }
?>