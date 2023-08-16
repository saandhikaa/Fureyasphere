<?php
   class Users extends Controller {
       private $app = "shared";
       private $data = [];
       
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