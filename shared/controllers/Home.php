<?php
    class Home extends Controller {
        private $appDir, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->appDir = basename(dirname(__DIR__));
            
            $this->data["mainAppDir"] = $this->appDir;
            $this->data["class"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
        }
        
        public function index() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE";
            
            $this->view($this->appDir, "templates/header", $this->data);
            $this->view($this->appDir, "$this->class/index");
            $this->view($this->appDir, "templates/footer", $this->data);
        }
        
        public function about() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE" ;
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $content = '<section class="readme shared"></section>';
            
            $this->view($this->appDir, "templates/header", $this->data);
            echo $content;
            $this->view($this->appDir, "templates/footer", $this->data);
        }
    }
?>