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
        
        public function createTable($tableName, $columns) {
            $columnDefinitions = [];
            $result = '';
            
            foreach ($columns as $columnName => $columnType) {
                $columnDefinitions[] = "$columnName $columnType";
            }
            
            // Check if table exists
            $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
            $this->db->query($checkTableQuery);
            $tableExists = $this->db->result();
            
            // If table exists, delete it
            if ($tableExists) {
                $deleteTableQuery = "DROP TABLE IF EXISTS $tableName";
                $this->db->query($deleteTableQuery);
                $result .= $this->db->execute() > 0 ? "<p>Table deleted.</p>" . PHP_EOL : "<p>Failed delete existing table.</p>" . PHP_EOL;
            }
            
            // Create table
            $createQuery = "CREATE TABLE IF NOT EXISTS $tableName (" . implode(", ", $columnDefinitions) . ")";
            $this->db->query($createQuery);
            $result .= $this->db->execute() > 0 ? "<p>Table created.</p>" . PHP_EOL : "<p>Failed create table.</p>" . PHP_EOL;
            
            return $result;
        }
        
        public static function generateFormFields($array) {
            $inputs = '';
            foreach ($array as $key => $value) {
                $inputs .= '<input type="hidden" name="table['. $key . ']" value="' . $value . '">' . PHP_EOL;
            }
            return $inputs;
        }
    }
?>