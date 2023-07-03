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

            foreach ($this->queryExecution->executeQuery("SHOW TABLES", TRUE) as $tableData) {
                $table = $tableData["Tables_in_" . $this->database];
                foreach ($this->queryExecution->executeQuery("SHOW COLUMNS FROM " . $table, TRUE) as $columnData) {
                    $tables[$table][] = $columnData["Field"];
                }
            }
            
            return $tables;
        }
        
        public function create ($sql) {
            $this->queryExecution->executeQuery($sql);
        }
        
        public function drop ($table) {
            $this->queryExecution->executeQuery("DROP TABLE " . $table);
        }
    }
?>