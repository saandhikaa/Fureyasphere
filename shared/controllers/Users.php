<?php
   class Users extends Controller {
       private $app = "shared";
       private $data = [];
       
        public function __construct() {
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/style.css">';
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/main.js"></script>';
        }
        
       public function index() {
           
       }
       
       public function registration() {
           $this->data["title"] = "Registration";
           
           $this->view($this->app, "templates/header", $this->data);
           $this->view($this->app, "users/registration");
           $this->view($this->app, "templates/footer", $this->data);
       }
   }
?>