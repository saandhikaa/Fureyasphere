<?php
    class Account extends Controller {
        private $appDir, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->appDir = basename(dirname(__DIR__));
            
            $this->data["mainAppDir"] = $this->appDir;
            $this->data["class"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
            $this->data["image-path"] = '<p class="image-path no-display">' . BASEURL . '/' . $this->appDir . '/assets/images/</p>' . PHP_EOL;
        }
        
        public function index() {
            try {
                $this->model($this->appDir, "AccountControl")->checkUsername(ADMIN_USERNAME);
            } catch (PDOException) {
                header("Location: " . BASEURL . "/$this->class/setup");
                exit;
            }
            
            if (!$this->model($this->appDir, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class/signin");
                exit;
            }
            
            $this->data["title"] = "Fureya: Account";
            
            $this->view($this->appDir, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/index", $this->data);
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function signup ($parameter = null) {
            if ($this->model($this->appDir, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class");
                exit;
            }
            
            if ($parameter === "checkusernameavailability") {
                // Handle the AJAX request
                if (isset($_POST["username"])) {
                    echo ($this->model($this->appDir, "AccountControl")->checkUsername($_POST["username"])) ? "available" : "taken";
                    exit;
                }
            } elseif (!is_null($parameter)) {
                header("Location: " . BASEURL . "/$this->class/signup");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model($this->appDir, "AccountControl")->signUp($_POST["username"], $_POST["password"])) {
                        if ($this->model($this->appDir, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                            header("Location: " . BASEURL . "/$this->class");
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign Up";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            $this->data["appScript"] .= '<script type="text/javascript">signUpValidation();</script>' . PHP_EOL;
            
            $this->view($this->appDir, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/signup", $this->data);
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function signin() {
            if ($this->model($this->appDir, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model($this->appDir, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                        header("Location: " . BASEURL . "/$this->class");
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] = "Fureya: Sign In";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            
            $this->view($this->appDir, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/signin", $this->data);
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function signout() {
            session_destroy();
            unset($_SESSION["sign-in"]);
            header("Location: " . BASEURL . "/$this->class/signin");
            exit;
        }
        
        public function setup() {
            $tableName = "users";
            
            try {
                if (!$this->model($this->appDir, "AccountControl")->checkUsername(ADMIN_USERNAME)) {
                    header("Location: " . BASEURL);
                    exit;
                }
            } catch (PDOException) {}
            
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if (isset($_POST["submit"]) && isset($_POST["table"])) {
                    $this->model($this->appDir, "TableMaster")->createTable($tableName, $_POST["table"]);
                    $this->model($this->appDir, "AccountControl")->signup(ADMIN_USERNAME, ADMIN_PASSWORD, 1);
                    header("Location: " . BASEURL . "/$this->class");
                    exit;
                }
            }
            
            $this->model($this->appDir, "TableMaster");
            $this->data["table-name"] = DB_NAME . '.' . $tableName;
            
            echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $this->view($this->appDir, "$this->class/setup", $this->data);
        }
    }
?>