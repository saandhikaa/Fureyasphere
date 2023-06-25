<?php
    // Database Connection Class
    class DatabaseConnection {
        private $host;
        private $username;
        private $password;
        private $database;
        private $conn;
    
        public function __construct($host, $username, $password, $database) {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;
            $this->database = $database;
        }
    
        public function connect() {
            $this->conn = new mysqli($this->host, $this->username, $this->password);
    
            // Check connection
            if ($this->conn->connect_error) {
                die("<br>Connection failed: " . $this->conn->connect_error);
            } else {
                echo "<br>Connected to server ($this->host)";
            }
            
            $query = "CREATE DATABASE IF NOT EXISTS $this->database";
            
            if ($this->conn->query($query) === TRUE) {
                echo "<br>Database ($this->database) created successfully";
            } else {
                echo "<br>Error creating database: " . $this->conn->error;
            }
            
            $this->closeConnection();
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            // Check connection
            if ($this->conn->connect_error) {
                die("<br>Connection failed: " . $this->conn->connect_error);
            } else {
                echo "<br>Connected to database ($this->database)";
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