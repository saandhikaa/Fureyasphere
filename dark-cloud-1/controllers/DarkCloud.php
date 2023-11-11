<?php
    class DarkCloud extends Controller {
        private $appDir, $class;
        private $data = [];
        private $table = "dc_uploads";
        
        public function __construct(Database $database) {
            $this->database = $database;
            
            $this->data["class"] = strtolower(__CLASS__);
            $this->data["dir"] = basename(dirname(__DIR__));
            
            $this->data["page-title"] = App::title($this->data['dir']);
            $this->data["navigation"] = true;
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->data['dir'] . '/assets/css/app.css">' . PHP_EOL;
            $this->data["script"][] = '<script src="' . BASEURL . '/' . $this->data['dir'] . '/assets/js/app.js"></script>' . PHP_EOL;
            
            try {
                $this->model($this->data['dir'], "FileHandler")->autoRemove();
            } catch (Exception $e) {}
        }
        
        public function index() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/{$this->data['class']}/result/" . $_POST["keyword"];
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->data['class']) . ": Search";
            
            $this->view("index", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/{$this->data['class']}/setup");
        }
        
        public function upload() {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $url = BASEURL . "/{$this->data['class']}/result/" . $this->model($this->data['dir'], "FileHandler")->upload() . "/uploaded";
                header("Location: $url");
                exit;
            }
            
            $this->data["title"] = ucfirst($this->data['class']) . ": Upload";
            $this->data["script"][] = '<script type="text/javascript">createInput();</script>' . PHP_EOL;
            
            $this->view("upload", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/{$this->data['class']}/setup");
        }
        
        public function result ($codename = null, $key = null, $action = "") {
            if (!empty($_POST) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0) {
                $this->model($this->data['dir'], "FileHandler")->download($_POST["filename"], $_POST["filepath"]);
            }
            
            $this->data["title"] = ucfirst($this->data['class']) . ": Result";
            $this->data["result"] = $this->model($this->data['dir'], "FileHandler")->loadFiles($codename, $key);
            $this->data["action"] = $action;
            $this->data["keyword"] = "$codename/$key";
            
            if (count($this->data["result"]) > 0) {
                $this->data["script"][] = '<script type="text/javascript">autorunResult();</script>' . PHP_EOL;
            }
            
            $this->view("result", $this->data);
            
            $this->database->tableExists($this->table, BASEURL . "/{$this->data['class']}/setup");
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
                    $this->database->dropAndCreateTable($this->table, $columns);
                    $this->model($this->data['dir'], "FileHandler")->createUploadsDir();
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
                            xhr.open("POST", "' . BASEURL . '/' . $this->data['class'] . '/setup", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("confirmed=true");
                            window.location.href = "' . BASEURL .'/' . $this->data['class'] . '";
                        } else {
                            window.location.href = "' . BASEURL . '";
                        }
                    </script>'; 
                } else {
                    echo '<script>
                        if(confirm("Access Denied, please sign out from current Account and provide a Level 1 Account.\n\nDo you wish to proceed to the sign-in page?")) {
                            window.location.href = "' . BASEURL . '/account/signin";
                        } else {
                            window.location.href = "' . BASEURL . '";
                        }
                    </script>';
                }
            } else {
                echo '<script>
                    if(confirm("Access Denied, please provide a Level 1 Account.\n\nDo you wish to proceed to the sign-in page?")) {
                        window.location.href = "' . BASEURL . '/account/signin/darkcloud/setup";
                    } else {
                        window.location.href = "' . BASEURL . '";
                    }
                </script>'; 
            }
        }
        
        public function about() {
            $this->data["content"] = '<main id="about">' . PHP_EOL;
            $this->data["content"] .= '<section class="readme ' . $this->data['dir'] . '"></section>' . PHP_EOL;
            $this->data["content"] .= '</main>' . PHP_EOL;
            
            $this->data["navigation"] = true;
            $this->data["script"][] = '<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>' . PHP_EOL;
            $this->data["script"][] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view("", $this->data);
        }
    }
?>