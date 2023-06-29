<?php
    require_once __DIR__ . "/../../config/database.php";
    
    class TableMaster {
        private $database, $queryExecution;
        
        public function __construct() {
            global $database, $queryExecution; 
            $this->database = $database;
            $this->queryExecution = $queryExecution;
        }
        
        public function showAll() {
            $tables = array();
            $t = $this->queryExecution->executeQuery("SHOW TABLES");
            for ($nt = 0; $nt < count($t); $nt++) {
                $table = $t[$nt]["Tables_in_" . $this->database];
                $h = $this->queryExecution->executeQuery("SHOW COLUMNS FROM " . $table);
                for ($nh = 0; $nh < count($h); $nh++) {
                    $tables[$table][$nh] = $h[$nh]["Field"];
                }
            }
            return $tables;
        }
    }
?>