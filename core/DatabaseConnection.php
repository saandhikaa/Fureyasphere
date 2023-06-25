<?php
    // Database Connection Class
    class DatabaseConnection {
        private $host;
        private $username;
        private $password;
        private $conn;
    
        public function __construct($host, $username, $password) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
        }
    
        public function connect() {
            $this->conn = new mysqli($this->host, $this->username, $this->password);
    
            // Check connection
            if ($this->conn->connect_error) {
                die("<br>Connection failed: " . $this->conn->connect_error);
            } else {
                echo "<br>Connected to server ($this->host)";
            }
        }
    
        public function getConnection() {
            return $this->conn;
        }
    
        public function closeConnection() {
            $this->conn->close();
        }
    }
    
?>