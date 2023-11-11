<?php
    class Account extends Controller {
        private $data = [];
        private $table = "users";
        
        public function __construct(Database $database) {
            $this->database = $database;
            
            $this->data["class"] = strtolower(__CLASS__);
            $this->data["dir"] = SHARED_DIR;
            
            $this->data["title"] = SITE_TITLE;
            $this->data["page-title"] = __CLASS__;
            $this->data["navigation"] = true;
            
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . SHARED_DIR . '/assets/css/app.css">' . PHP_EOL;
            $this->data["script"][] = '<script src="' . BASEURL . '/' . $this->data['dir'] . '/assets/js/appAccount.js"></script>' . PHP_EOL;
        }
        
        public function index() {
            if (!$this->model(SHARED_DIR, "AccountControl")->isLoggedIn()) {
                header("Location: " . BASEURL . "/{$this->data['class']}/signin");
                exit;
            }
            
            $this->data["navigation"] = true;
            
            $this->view("index", $this->data);
        }
        
        public function signup ($parameter = null) {
            if ($this->model(SHARED_DIR, "AccountControl")->isLoggedIn()) {
                header("Location: " . BASEURL . "/{$this->data['class']}");
                exit;
            }
            
            if ($parameter === "checkusernameavailability") {
                // Handle the AJAX request
                if (isset($_POST["username"])) {
                    echo ($this->model(SHARED_DIR, "AccountControl")->userRegistered($_POST["username"])) ? "taken" : "available" ;
                    exit;
                }
            } elseif (!is_null($parameter)) {
                header("Location: " . BASEURL . "/{$this->data['class']}/signup");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign Up") {
                    if ($this->model(SHARED_DIR, "AccountControl")->signUp($_POST)) {
                        if ($this->model(SHARED_DIR, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                            header("Location: " . BASEURL . "/{$this->data['class']}");
                            exit;
                        }
                    } else {
                        echo "failed create account";
                    }
                }
            }
            
            $this->data["title"] .= ": Sign Up";
            $this->data["script"][] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            $this->data["script"][] = '<script type="text/javascript">signUpValidation();</script>' . PHP_EOL;
            
            $this->view("signup", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/{$this->data['class']}/setup");
        }
        
        public function signin($redirect = null, $subRedirect = "") {
            if ($this->model(SHARED_DIR, "AccountControl")->isLoggedIn()) {
                header("Location: " . BASEURL . "/{$this->data['class']}");
                exit;
            }
            
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Sign In") {
                    if ($this->model(SHARED_DIR, "AccountControl")->signIn($_POST["username"], $_POST["password"])) {
                        if (is_null($redirect)) {
                            header("Location: " . BASEURL . "/{$this->data['class']}");
                        } elseif (!empty($redirect)) {
                            header("Location: " . BASEURL . "/$redirect/$subRedirect");
                        }
                        exit;
                    } else {
                        $this->data["sign-in-failed"] = "Username/password incorrect";
                    }
                }
            }
            
            $this->data["title"] .= ": Sign In";
            $this->data["script"][] = '<script type="text/javascript">thicknessSVG(' . "'.passwordVisibility path', '15');</script>" . PHP_EOL;
            
            $this->view("signin", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/{$this->data['class']}/setup");
        }
        
        public function signout() {
            session_destroy();
            unset($_SESSION["sign-in"]);
            header("Location: " . BASEURL . "/{$this->data['class']}/signin");
            exit;
        }
        
        public function delete() {
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == BASEURL . "/account") {
                if ($this->model(SHARED_DIR, "AccountControl")->dropUser()) {
                    header("Location: " . BASEURL . "/{$this->data['class']}/signout");
                    exit;
                }
            }
        }
        
        public function terms() {
            $this->data["navigation"] = false;
            $this->view("terms-of-service", $this->data);
        }
        
        public function privacy() {
            $this->data["navigation"] = false;
            $this->view("privacy-policy", $this->data);
        }
        
        public function setup() {
            if ($this->database->tableExists($this->table) && (!isset($_SESSION["sign-in"]["username"]) || $_SESSION["sign-in"]["username"] !== ADMIN_USERNAME)) {
                header("Location: " . BASEURL . "/{$this->data['class']}");
                exit;
            }
            
            $columns = "(
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                time_ INT(10) NOT NULL,
                username_ VARCHAR(12) NOT NULL,
                password_ VARCHAR(255) NOT NULL,
                level_ INT(2) NOT NULL,
                agreed_ TINYINT(1) NOT NULL
            )";
            
            // Handle AJAX
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if ($_POST["confirmed"] == 'true') {
                    $this->database->dropAndCreateTable($this->table, $columns);
                    $this->model(SHARED_DIR, "AccountControl")->signup(["username" => ADMIN_USERNAME, "password" => ADMIN_PASSWORD, "agreement" => 1], 1);
                    exit;
                }
            }
            
            $confirm = 'A new [' . $this->table . '] will be created with the following default account credentials:\n\nUsername\t: ' .  ADMIN_USERNAME . '\nPassword\t: ' . ADMIN_PASSWORD . '\n\nPlease confirm if you wish to proceed.';
            echo '<script type="text/javascript">
                var r = confirm("' . $confirm . '");
                if (r == true) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "' . BASEURL . '/' . $this->data['class'] . '/setup", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("confirmed=true");
                    window.location.href = "' . BASEURL .'/' . $this->data['class'] . '";
                } else {
                    window.location.href = "' . BASEURL . '";
                }
            </script>';
            
            $this->database->closing();
        }
    }
?>