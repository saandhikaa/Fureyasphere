<?php
    class Account extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["app"] = $this->class;
            $this->data["styles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->app . '/assets/css/style.css">';
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->app . '/assets/js/main.js"></script>';
        }
        
        public function index() {
            if (!$this->model($this->app, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class/signin");
                exit;
            }
            
            $this->data["title"] = "Fureya: Account";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/index", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signup ($parameter = null) {
            if ($parameter === "checkusernameavailability") {
                // Handle the AJAX request
                if (isset($_POST["username"])) {
                    echo ($this->model($this->app, "AccountControl")->checkUsername($_POST["username"])) ? "available" : "taken";
                    exit;
                }
            } elseif (!is_null($parameter)) {
                header("Location: " . BASEURL . "/$this->class/signup");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model($this->app, "AccountControl")->signUp($_POST["username"], $_POST["password"])) {
                        if ($this->model($this->app, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                            header("Location: " . BASEURL . "/$this->class");
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign Up";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/signup", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signin() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model($this->app, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                        header("Location: " . BASEURL . "/$this->class");
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign In";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/signin", $this->data);
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function signout() {
            session_destroy();
            unset($_SESSION["sign-in"]);
            header("Location: " . BASEURL . "/$this->class/signin");
            exit;
        }
        
        public function setup() {
            $tableName = "users";
            
            $this->model($this->app, "TableMaster")->createTable($tableName);
            
            $this->data["title"] = "Fureya: Setup";
            $this->data["table"] = $this->model($this->app, "TableMaster")->getTableStructure($tableName);
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/setup", $this->data);
            $this->view($this->app, "templates/footer");
        }
    }
?>