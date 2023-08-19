<?php
    class UserMaster {
        private $db;
        private $table = "users";
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function checkUsername ($username) {
            $query = "SELECT username_ FROM $this->table WHERE username_ = :username";
            $this->db->query($query);
            $this->db->bind(':username', $username);
            
            return empty($this->db->result());
        }
    }
?>