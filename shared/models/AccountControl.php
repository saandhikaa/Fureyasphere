<?php
    class AccountControl {
        private $db;
        private $table = "users";
        
        public function __construct(Database $database) {
            $this->db = $database;
        }
        
        public function isLoggedIn() {
            if (isset($_SESSION["sign-in"]["uid"])) {
                $userData = $this->db->fetching("SELECT * FROM $this->table WHERE time_ = '{$_SESSION["sign-in"]["uid"]}'");
                return !empty($userData[0]) ? $userData[0] : false ;
            }
        }
        
        public function userRegistered ($username) {
            $result = $this->db->fetching("SELECT username_ FROM $this->table WHERE username_ = '$username'");
            return !empty($result);
        }
        
        public function signUp ($data, $level = 3) {
            if ($this->userRegistered($data["username"])) {
                return ($this->signIn($data["username"], $data["password"]));
            }
            
            $hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);
            $time = time();
            if (! $agreement_accepted = isset($data["agreement"]) ? 1 : 0 ) {
                return false;
            }
            
            return $this->db->executing("INSERT INTO $this->table (time_, username_, password_, level_, agreed_) VALUES ($time, '{$data["username"]}', '$hashedPassword', $level, $agreement_accepted)");
        }
        
        public function signIn ($username, $password) {
            $userData = $this->db->fetching("SELECT * FROM $this->table WHERE username_ = '$username'");
            
            if (!empty($userData) && password_verify($password, $userData[0]["password_"])) {
                $_SESSION["sign-in"]["username"] = $userData[0]["username_"];
                $_SESSION["sign-in"]["uid"] = $userData[0]["time_"];
                return true;
            } else {
                return false;
            }
        }
        
        public function dropUser() {
            return $this->db->executing("DELETE FROM $this->table WHERE time_ = {$_SESSION['sign-in']['uid']}");
        }
    }
?>