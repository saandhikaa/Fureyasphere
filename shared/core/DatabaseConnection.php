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
                die("Connection failed: " . $this->conn->connect_error) . ".<br>";
            } else {
                echo "Connected to server ($this->host).<br>";
            }
            
            $query = "CREATE DATABASE IF NOT EXISTS $this->database";
            
            if ($this->conn->query($query) === TRUE) {
                echo "Database ($this->database) ready.<br>";
            } else {
                echo "Error creating database: " . $this->conn->error . ".<br>";
            }
            
            $this->closeConnection();
            
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error) . ".<br>";
            } else {
                echo "Connected to database ($this->database).<br>";
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