<?php
    class TableMaster {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function getTableStructure ($tableName) {
            $query = "SHOW COLUMNS FROM $tableName";
            try {
                $this->db->query($query);
                $this->db->execute();
                return $this->db->result(true);
            } catch (PDOException $e) {
                return false;
            }
        }
        
        public function createTable ($tableName) {
            if (isset($_POST["submit"]) && isset($_POST["table"])) {
                $columns = $_POST["table"];
                $columnDefinitions = [];
                foreach ($columns as $columnName => $columnType) {
                    $columnDefinitions[] = "$columnName $columnType";
                }
                
                $query = "CREATE TABLE IF NOT EXISTS $tableName (" . implode(", ", $columnDefinitions) . ")";
                
                $this->db->query($query);
                $this->db->execute();
            } 
        }
    }
?>