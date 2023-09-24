<?php
    class Home extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["mainApp"] = $this->app;
            $this->data["app"] = "Fureya Clouds Service";
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
        }
        
        public function index() {
            $this->data["title"] = strtoupper($this->data["app"]);
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/index");
            $this->view($this->app, "templates/footer", $this->data);
        }
    }
?>