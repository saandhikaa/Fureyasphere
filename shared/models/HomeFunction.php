<?php
    class HomeFunction {
        private $dataDir, $commentPath;
        
        public function __construct() {
            $this->dataDir = __DIR__ . "/../data-userfilesbox";
            $this->commentPath = $this->dataDir . "/comments.json";
            
            if (!is_dir($this->dataDir)) {
                mkdir($this->dataDir, 0777, true);
            }
            if (!file_exists($this->commentPath)) {
                file_put_contents($this->commentPath, json_encode([]));
            }
        }
    }
?>