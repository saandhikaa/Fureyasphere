<?php
    class Home extends Controller {
        private $appDir, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->appDir = basename(dirname(__DIR__));
            
            $this->data["mainAppDir"] = $this->appDir;
            $this->data["title"] = "FUREYA CLOUDS SERVICE";
            $this->data["class"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
        }
        
        public function index() {
            $this->data["main-id"] = "home";
            $this->data["page-title"] = "Fureya Clouds Service";
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->appDir . '/assets/css/main.css">' . PHP_EOL;
            $this->data["script"][] = '<script src="' . BASEURL . '/' . $this->appDir . '/assets/js/main.js"></script>' . PHP_EOL;
            $this->data["body"][] = __DIR__ . "/../" . "/views/$this->class/index.php";
            $this->data["navigation"] = true;
            
            $this->view($this->appDir, "layout/main", $this->data);
        }
        
        public function about() {
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view($this->appDir, "templates/header", $this->data);
            echo '<main id="home-about">' . PHP_EOL;
            echo '<section class="readme shared"></section>' . PHP_EOL;
            foreach (App::getAppList(true) as $app) {
                echo '<section class="readme ' . $app["dir"][0] . '"></section>' . PHP_EOL;
            }
            echo '</main>' . PHP_EOL;
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function resources() {
            $this->data["title"] = "Resources";
            $this->data["main-id"] = "resources";
            $this->data["page-title"] = "Resources";
            $this->data["style"][] = '<link rel="stylesheet" href="' . BASEURL . '/' . $this->appDir . '/assets/css/resources.css">' . PHP_EOL;
            $this->data["script"][] = '<script src="' . BASEURL . '/' . $this->appDir . '/assets/js/resources.js"></script>' . PHP_EOL;
            
            foreach (App::getAppList(true) as $app) {
                foreach ($app["class"] as $appClass) {
                    $appClass = strtolower($appClass);
                    if ($app["dir"][0] != $this->appDir || $appClass == $this->class) {
                        $this->data["body"][] = __DIR__ . "/../../" . $app["dir"][0] . "/views/$appClass/resources.php";
                    }
                }
            }
            $this->view($this->appDir, "layout/main", $this->data);
        }
        
        public function terms() {
            $this->data["web-application"] = "Fureya Clouds Service";
            $this->view($this->appDir, "$this->class/terms-of-service", $this->data);
        }
        
        public function privacy() {
            $this->data["web-application"] = "Fureya Clouds Service";
            $this->view($this->appDir, "$this->class/privacy-policy", $this->data);
        }
    }
?>