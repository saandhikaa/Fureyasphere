<?php
    class TableMaster {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
    }
?>