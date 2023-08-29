<?php
    class Home extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["app"] = "Fureya Clouds Service";
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/style.css">';
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/main.js"></script>'; 
        }
        
        public function index() {
            $this->data["title"] = strtoupper($this->data["app"]);
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/index");
            $this->view($this->app, "templates/footer");
        }
    }
?>