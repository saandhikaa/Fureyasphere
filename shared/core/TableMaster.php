<?php
    class TableMaster {
        private $database, $queryExecution;
        
        public function __construct() {
            global $database, $queryExecution; 
            $this->database = $database;
            $this->queryExecution = $queryExecution;
        }
        
        public function getList() {
            $tables = array();
            $t = $this->queryExecution->executeQuery("SHOW TABLES", TRUE);
            for ($nt = 0; $nt < count($t); $nt++) {
                $table = $t[$nt]["Tables_in_" . $this->database];
                $h = $this->queryExecution->executeQuery("SHOW COLUMNS FROM " . $table, TRUE);
                for ($nh = 0; $nh < count($h); $nh++) {
                    $tables[$table][$nh] = $h[$nh]["Field"];
                }
            }
            return $tables;
        }
        
        public function create ($sql) {
            $this->queryExecution->executeQuery($sql);
        }
    }
?>