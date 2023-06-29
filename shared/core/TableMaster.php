<?php
    require_once __DIR__ . "/../../config/database.php";
    
    class TableMaster {
        private $database, $queryExecution;
        
        public function __construct() {
            global $database, $queryExecution; 
            $this->database = $database;
            $this->queryExecution = $queryExecution;
        }
    }
?>