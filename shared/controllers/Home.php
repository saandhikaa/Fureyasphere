<?php
    class Home extends Controller {
        private $app;
        private $data = [];
        
        public function __construct() {
            $this->app = basename(dirname(__DIR__));
            
            $this->data["app"] = "Fureya Clouds Service";
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/style.css">';
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/main.js"></script>'; 
        }
        
        public function index() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view("shared", "home/index");
            $this->view("shared", "templates/footer");
        }
    }
?>