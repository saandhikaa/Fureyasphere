<?php
    class UserMaster {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function checkUsername ($username) {
            $query = "SELECT COUNT(*) FROM users WHERE username = :username";
            $this->db->query($query);
            $this->db->bind(':username', $username);
            $this->db->execute();
            
            return $this->db->rowCount() === 0;
        }
    }
?>