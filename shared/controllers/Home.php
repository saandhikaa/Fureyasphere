<?php
    class Home extends Controller {
        private $data = [];
        
        public function index() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE";
            
            $this->view("shared", "templates/header", $this->data);
            $this->view("shared", "home/index");
            $this->view("shared", "templates/footer");
        }
    }
?>