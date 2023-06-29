<?php
    class FileHandler {
        private $queryExecution; 
        
        public function __construct() {
            global $queryExecution;
            $this->queryExecution = $queryExecution;
        }
    }
?>