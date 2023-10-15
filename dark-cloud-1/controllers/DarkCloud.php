<?php
    class DarkCloud extends Controller {
        private $appDir, $class;
        private $data = [];
        private $table = "uploads";
        
        public function __construct(Database $database) {
            $this->database = $database;
            
            $this->class = strtolower(__CLASS__);
            $this->appDir = basename(dirname(__DIR__));
            
            $this->data["page-title"] = App::title($this->appDir);
            $this->data["class"] = $this->class;
            $this->data["issue"] = GITHUB . "Fureyasphere/issues";
            $this->data["appStyles"] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->appDir . '/assets/css/app.css">' . PHP_EOL;
            $this->data["appScript"] = '<script src="' . BASEURL . '/' . $this->appDir . '/assets/js/app.js"></script>' . PHP_EOL;
            $this->data["image-path"] = '<p class="image-path no-display">' . BASEURL . '/' . $this->appDir . '/assets/images/</p>' . PHP_EOL;
            
            try {
                $this->model($this->appDir, "FileHandler")->autoRemove();
            } catch (Exception $e) {}
        }
        
        public function index() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $_POST["keyword"];
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Search";
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/index", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/$this->class/setup");
        }
        
        public function upload() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/$this->class/result/" . $this->model($this->appDir, "FileHandler")->upload() . "/uploaded";
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Upload";
            $this->data["appScript"] .= '<script type="text/javascript">createInput();</script>' . PHP_EOL;
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/upload", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/$this->class/setup");
        }
        
        public function result ($codename = null, $key = null, $action = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $this->model($this->appDir, "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
            }
            
            $this->data["title"] = ucfirst($this->class) . ": Result";
            $this->data["result"] = $this->model($this->appDir, "FileHandler")->loadFiles($codename, $key);
            $this->data["action"] = $action;
            $this->data["keyword"] = "$codename/$key";
            $this->data["appDir"] = $this->appDir;
            
            if (count($this->data["result"]) > 0) {
                $this->data["appScript"] .= '<script type="text/javascript">autorunResult();</script>' . PHP_EOL;
            }
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/result", $this->data);
            $this->view(SHARED_DIR, "templates/footer", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/$this->class/setup");
        }
        
        public function setup() {
            $columns = "(
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                time_ INT(10) NOT NULL,
                owner_ VARCHAR(20) NOT NULL,
                codename_ VARCHAR(20) NOT NULL,
                key_ INT(2) NOT NULL,
                filename_ VARCHAR(100) NOT NULL,
                filesize_ INT(11) NOT NULL,
                duration_ int(4) NOT NULL,
                available_ VARCHAR(3) NOT NULL
            )";
            
            // Handle AJAX
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                if ($_POST["confirmed"] == 'true') {
                    $this->database->dropAndCreateTable($this->table, "CREATE TABLE $this->table $columns");
                    $this->model($this->appDir, "FileHandler")->createUploadsDir();
                    exit;
                }
            }
            
            if (isset($_SESSION["sign-in"])) {
                $userData = $this->model(SHARED_DIR, "AccountControl")->isLoggedIn();
                if ($userData && $userData["level_"] == 1) {
                    $confirm = 'A new [' . $this->table . '] and upload storage will be created.\n\nPlease confirm if you wish to proceed.';
                    echo '<script type="text/javascript">
                        var r = confirm("' . $confirm . '");
                        if (r == true) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "' . BASEURL . '/' . $this->class . '/setup", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("confirmed=true");
                            window.location.href = "' . BASEURL .'/' . $this->class . '";
                        } else {
                            window.location.href = "' . BASEURL . '";
                        }
                    </script>'; 
                } else {
                    echo '<script>
                        if(confirm("Access Denied, please sign out from current Account and provide a Level 1 Account.\n\nDo you wish to proceed to the sign-in page?")) {
                            window.location.href = "' . BASEURL . '/account/signin/";
                        } else {
                            window.location.href = "' . BASEURL . '";
                        }
                    </script>';
                }
            } else {
                echo '<script>
                    if(confirm("Access Denied, please provide a Level 1 Account.\n\nDo you wish to proceed to the sign-in page?")) {
                        window.location.href = "' . BASEURL . '/account/signin/";
                    } else {
                        window.location.href = "' . BASEURL . '";
                    }
                </script>'; 
            }
        }
        
        public function about() {
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            echo '<main id="home-about">' . PHP_EOL;
            echo '<section class="readme ' . $this->appDir . '"></section>' . PHP_EOL;
            echo '</main>' . PHP_EOL;
            $this->view(SHARED_DIR, "templates/footer", $this->data);
        }
    }
?>