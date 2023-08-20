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
        
        public function signUp ($username, $password) {
            if (!$this->checkUsername($username)) {
                return ($this->signIn($username, $password));
            }
            
            // Hash the password using password_hash function
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $this->db->query("INSERT INTO $this->table (time_, username_, password_, level_) VALUES (:time, :username, :password, :level)");
            $this->db->bind(':time', time());
            $this->db->bind(':username', $username);
            $this->db->bind(':password', $hashedPassword);
            $this->db->bind(':level', '1');
            $this->db->execute();
            
            return $this->db->rowCount() > 0;
        }
    }
?>