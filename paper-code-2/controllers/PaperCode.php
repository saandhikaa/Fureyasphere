<?php
    class PaperCode extends Controller {
        private $appDir, $class;
        private $data = [];
        
        public function __construct (Database $database) {
            $this->database = $database;
            
            $this->data["class"] = strtolower(__CLASS__);
            $this->data["dir"] = basename(dirname(__DIR__));
            
            $this->data["page-title"] = App::title($this->data['dir']);
            $this->data["navigation"] = true;
        }
        
        public function index() {
            $this->view("index", $this->data);
        }
    }
?>