<?php
    class Home extends Controller {
        private $data = [];
        
        public function __construct(Database $database) {
            $this->database = $database;
            
            $this->data["class"] = strtolower(__CLASS__);
            $this->data["dir"] = SHARED_DIR;
            
            $this->data["title"] = SITE_TITLE;
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . SHARED_DIR . '/assets/css/app.css">' . PHP_EOL;
            $this->data["script"][] = '<script src="' . BASEURL . '/' . $this->data['dir'] . '/assets/js/appHome.js"></script>' . PHP_EOL;
        }
        
        public function index() {
            $this->data["page-title"] = SITE_TITLE;
            $this->data["navigation"] = true;
            
            $this->view("index", $this->data);
        }
        
        public function comment() {
            if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], BASEURL) === 0 && isset($_POST["submit"])) {
                if ($_POST["submit"] === "Send" && !empty($_POST["message"])) {
                    $data = [
                        "time" => time(),
                        "uid" => $_SESSION["sign-in"]["uid"],
                        "replied" => $_POST["replied"],
                        "message" => $_POST["message"]
                    ];
                    if (isset($_POST["mention"])) {
                        $data["mention"] = $_POST["mention"];
                    }
                    $this->model(SHARED_DIR, "HomeFunction")->addComment($data);
                    
                    header("Location: " . BASEURL . "/home/comment");
                    exit;
                }
            }
            
            $this->data["comment-lists"] = $this->model(SHARED_DIR, "HomeFunction")->loadComments();
            
            $this->data["page-title"] = SITE_TITLE;
            $this->data["navigation"] = true;
            
            $this->view("comment", $this->data);
        }
        
        public function about() {
            $this->data["content"] = '<main id="home-about">' . PHP_EOL;
            $this->data["content"] .= '<section class="readme shared"></section>' . PHP_EOL;
            foreach (App::getAppList() as $app) {
                if (file_exists(__DIR__ . "/../../" . $app["dir"][0] . "/README.md")) {
                    $this->data["content"] .= '<section class="readme ' . $app["dir"][0] . '"></section>' . PHP_EOL;
                }
            }
            $this->data["content"] .= '</main>';
            
            $this->data["page-title"] = SITE_TITLE;
            $this->data["navigation"] = true;
            $this->data["script"][] = '<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>' . PHP_EOL;
            $this->data["script"][] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view("", $this->data);
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