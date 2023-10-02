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
            $this->view($this->appDir, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/index");
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function about() {
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $this->view($this->appDir, "templates/header", $this->data);
            echo '<main id="home-about">' . PHP_EOL;
            echo '<section class="readme shared"></section>' . PHP_EOL;
            foreach (App::getAppList() as $appDir => $class) {
                echo '<section class="readme ' . $appDir . '"></section>' . PHP_EOL;
            }
            echo '</main>' . PHP_EOL;
            $this->view($this->appDir, "templates/footer", $this->data);
        }
    }
?>