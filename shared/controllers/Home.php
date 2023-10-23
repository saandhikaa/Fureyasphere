<?php
    class Home extends Controller {
        private $data = [];
        
        public function __construct(Database $database) {
            $this->database = $database;
            
            $this->data["class"] = strtolower(__CLASS__);
            $this->data["dir"] = SHARED_DIR;
            
            $this->data["title"] = SITE_TITLE;
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . SHARED_DIR . '/assets/css/home.css">' . PHP_EOL;
        }
        
        public function index() {
            $this->data["page-title"] = SITE_TITLE;
            $this->data["navigation"] = true;
            
            $this->view("index", $this->data);
        }
        
        public function comment() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "send") {
                    $data = [
                        "time" => time(),
                        "uid" => $_SESSION["sign-in"]["uid"],
                        "mentioned" => $_POST["mentioned"],
                        "message" => $_POST["message"]
                    ];
                    $this->model(SHARED_DIR, "HomeFunction")->addComment($data);
                }
            }
            
            $this->data["comment-lists"] = $this->model(SHARED_DIR, "HomeFunction")->loadComments();
            
            $this->data["page-title"] = SITE_TITLE;
            $this->data["navigation"] = true;
            
            $this->view("comment", $this->data);
        }
        
        public function about() {
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view(SHARED_DIR, "templates/header", $this->data);
            echo '<main id="home-about">' . PHP_EOL;
            echo '<section class="readme shared"></section>' . PHP_EOL;
            foreach (App::getAppList() as $app) {
                if (file_exists(__DIR__ . "/../../" . $app["dir"][0] . "/README.md")) {
                    echo '<section class="readme ' . $app["dir"][0] . '"></section>' . PHP_EOL;
                }
            }
            echo '</main>' . PHP_EOL;
            $this->view(SHARED_DIR, "templates/footer", $this->data);
        }
        
        public function resources() {
            foreach (App::getAppList(true) as $app) {
                foreach ($app["class"] as $appClass) {
                    $appClass = strtolower($appClass);
                    if ($app["dir"][0] != SHARED_DIR || $appClass == $this->data["class"]) {
                        $resource = __DIR__ . "/../../" . $app["dir"][0] . "/views/$appClass/resources.php";
                        if (file_exists($resource)) {
                            require_once $resource;
                        }
                    }
                }
            }
            
            $this->data["page-title"] = SITE_TITLE;
            
            $this->data["content"] = "<h1>Resources</h1>" . PHP_EOL;
            foreach ($list as $key => $ul) {
                $this->data["content"] .= "<h2>" . ucwords(str_replace("-", " ", $key)) . "</h2>" . PHP_EOL;
                $this->data["content"] .= "<ul>" . PHP_EOL;
                foreach ($ul as $li) {
                    $this->data["content"] .= $li . PHP_EOL;
                }
                $this->data["content"] .= "</ul>" . PHP_EOL;
            }
            
            $this->view("", $this->data);
        }
        
        public function terms() {
            $this->view("terms-of-use", $this->data);
        }
        
        public function privacy() {
            $this->view("privacy-policy", $this->data);
        }
    }
?>