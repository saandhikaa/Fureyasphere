<?php
    class Account extends Controller {
        private $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            
            $this->data["title"] = SITE_TITLE;
            $this->data["page-title"] = __CLASS__;
            $this->data["class"] = $this->class;
            $this->data["issue"] = GITHUB . "Fureyasphere/issues";
            $this->data["image-path"] = '<p class="image-path no-display">' . BASEURL . '/' . SHARED_DIR . '/assets/images/</p>' . PHP_EOL;
        }
        
        public function index() {
            $this->checkTableExists();
            
            if (!$this->model(SHARED_DIR, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class/signin");
                exit;
            }
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view(SHARED_DIR, "$this->class/index", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
        }
        
        public function signup ($parameter = null) {
            $this->checkTableExists();
            
            if ($this->model(SHARED_DIR, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class");
                exit;
            }
            
            if ($parameter === "checkusernameavailability") {
                // Handle the AJAX request
                if (isset($_POST["username"])) {
                    echo ($this->model(SHARED_DIR, "AccountControl")->checkUsername($_POST["username"])) ? "available" : "taken";
                    exit;
                }
            } elseif (!is_null($parameter)) {
                header("Location: " . BASEURL . "/$this->class/signup");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model(SHARED_DIR, "AccountControl")->signUp($_POST["username"], $_POST["password"])) {
                        if ($this->model(SHARED_DIR, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                            header("Location: " . BASEURL . "/$this->class");
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] .= ": Sign Up";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            $this->data["appScript"] .= '<script type="text/javascript">signUpValidation();</script>' . PHP_EOL;
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view(SHARED_DIR, "$this->class/signup", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
        }
        
        public function signin($redirect = null) {
            $this->checkTableExists();
            
            if ($this->model(SHARED_DIR, "AccountControl")->checkSignInInfo()) {
                header("Location: " . BASEURL . "/$this->class");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model(SHARED_DIR, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                        if (is_null($redirect)) {
                            header("Location: " . BASEURL . "/$this->class");
                        } elseif (!empty($redirect)) {
                            header("Location: " . BASEURL . "/$redirect");
                        }
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] .= ": Sign In";
            $this->data["appScript"] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view(SHARED_DIR, "$this->class/signin", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
        }
        
        public function signout() {
            session_destroy();
            unset($_SESSION["sign-in"]);
            header("Location: " . BASEURL . "/$this->class/signin");
            exit;
        }
        
        public function terms() {
            $this->view(SHARED_DIR, "$this->class/terms-of-service", $this->data);
        }
        
        public function privacy() {
            $this->view(SHARED_DIR, "$this->class/privacy-policy", $this->data);
        }
        
        public function setup() {
            $tableName = "users";
            
            try {
                if (!$this->model(SHARED_DIR, "AccountControl")->checkUsername(ADMIN_USERNAME)) {
                    header("Location: " . BASEURL);
                    exit;
                }
            } catch (PDOException) {}
            
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if (isset($_POST["submit"]) && isset($_POST["table"])) {
                    $this->model(SHARED_DIR, "TableMaster")->createTable($tableName, $_POST["table"]);
                    $this->model(SHARED_DIR, "AccountControl")->signup(ADMIN_USERNAME, ADMIN_PASSWORD, 1);
                    header("Location: " . BASEURL . "/$this->class");
                    exit;
                }
            }
            
            $this->model(SHARED_DIR, "TableMaster");
            
            $this->data["title"] .= ": Setup " . ucfirst($this->class);
            $this->data["confirm"] = 'A new [' . DB_NAME . '.' . $tableName . '] will be created with the following default account credentials:\n\nUsername\t: ' .  ADMIN_USERNAME . '\nPassword\t: ' . ADMIN_PASSWORD . '\n\nPlease confirm if you wish to proceed.';
            $this->data["button"] = "Create Table [$tableName]";
            $this->data["columns"] = [
                "id" => "INT(11) AUTO_INCREMENT PRIMARY KEY",
                "time_" => "INT(10) NOT NULL",
                "username_" => "VARCHAR(12) NOT NULL",
                "password_" => "VARCHAR(255) NOT NULL",
                "level_" => "INT(2) NOT NULL"
            ];
            
            $this->view(SHARED_DIR, "shares/setup-table", $this->data);
        }
        
        private function checkTableExists() {
            try {
                $this->model(SHARED_DIR, "AccountControl")->checkUsername(ADMIN_USERNAME);
            } catch (PDOException) {
                header("Location: " . BASEURL . "/$this->class/setup");
                exit;
            }
        }
    }
?>