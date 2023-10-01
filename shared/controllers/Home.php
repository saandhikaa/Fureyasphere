<?php
    class Home extends Controller {
        private $app, $class;
        private $data = [];
        
        public function __construct() {
            $this->class = strtolower(__CLASS__);
            $this->app = basename(dirname(__DIR__));
            
            $this->data["mainApp"] = $this->app;
            $this->data["app"] = $this->class;
            $this->data["issue"] = "https://github.com/saandhikaa/fureya-clouds-service/issues";
        }
        
        public function index() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE";
            
            $this->view($this->app, "templates/header", $this->data);
            $this->view($this->app, "$this->class/index");
            $this->view($this->app, "templates/footer", $this->data);
        }
        
        public function about() {
            $this->data["title"] = "FUREYA CLOUDS SERVICE" ;
            $this->data["appScript"] = '<script type="text/javascript">loadReadme();</script>' . PHP_EOL;
            
            $content = '<section class="readme shared"></section>';
            
            $this->view($this->app, "templates/header", $this->data);
            echo $content;
            $this->view($this->app, "templates/footer", $this->data);
        }
    }
?>