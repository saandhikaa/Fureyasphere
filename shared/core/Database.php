<?php
    class Database {
        public $conn;
        
        public function __construct() {
            $this->conn = null;    
            try {
                $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            } catch (Exception $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
        }
        
        public function fetching ($query) {
            $result = $this->conn->query($query);
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            return $rows;
        }
        
        public function executing ($query) {
            return $this->conn->query($query);
        }
        
        public function dropAndCreateTable($tableName, $createTableSQL) {
            $dropQuery = "DROP TABLE IF EXISTS $tableName";
            $createQuery = $createTableSQL;
            
            $this->conn->query($dropQuery);
            return $this->conn->query($createQuery);
        }
        
        public function closing() {
            $this->conn->close();
        }
    }
?>