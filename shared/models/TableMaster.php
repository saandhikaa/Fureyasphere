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
    }
?>