<?php
    class Home extends Controller {
        public function index() {
            $this->view("shared", "templates/header");
            $this->view("shared", "home/index");
            $this->view("shared", "templates/footer");
        }
    }
?>