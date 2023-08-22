<?php
    class Users extends Controller {
        private $app = "shared";
        private $data = [];
        
        public function __construct() {
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/style.css">';
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/main.js"></script>';
        }
        
        public function index() {
            if (!$this->model($this->app, "UserMaster")->checkSignInInfo()) {
                $this->login();
                exit;
            }
            
            $this->data["title"] = "User Account";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "users/index");
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function registration() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model($this->app, "UserMaster")->signUp($_POST["username"], $_POST["password"])) {
                        if ($this->model($this->app, "UserMaster")->signIn($_POST["username"], $_POST["password"])) {
                            $this->index();
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] = "Registration";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "users/registration");
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function login() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model($this->app, "UserMaster")->signIn($_POST["username"], $_POST["password"])) {
                        $this->index();
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] = "Sign In";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "users/login", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        // Handle the AJAX request
        public function usernameavailability() {
            if (isset($_POST["username"])) {
                echo ($this->model($this->app, "UserMaster")->checkUsername($_POST["username"])) ? "available" : "taken";
            }
        }
        
        public function setup() {
            $tableName = "users";
            
            $this->model($this->app, "TableMaster")->createTable($tableName);
            
            $this->data["title"] = "Setup";
            $this->data["table"] = $this->model($this->app, "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "users/setup", $this->data);
            $this->view($this->app, "templates/footer");
        }
    }
?>