<?php
    class Database {
        public $conn;
        
        public function __construct() {
            $this->conn = null;    
            try {
                $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            } catch (Exception $exception) {
                die("<h1>Connection error: " . $exception->getMessage() . "</h1>");
            }
            return $this->conn;
        }
        
        public function querying($sql, $params = [], $types = "") {
            $stmt = $this->conn->prepare($sql);
            if($stmt === false) {
                die('prepare() failed: ' . htmlspecialchars($this->conn->error));
            }
            
            if ($params) {
                $types = str_repeat('s', count($params)); // assumes all parameters are strings
                $stmt->bind_param($types, ...$params);
            }
            
            $stmt->execute();
            return $stmt;
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
        
        public function dropAndCreateTable ($tableName, $createTableSQL) {
            $dropQuery = "DROP TABLE IF EXISTS $tableName";
            $createQuery = $createTableSQL;
            
            $this->conn->query($dropQuery);
            return $this->conn->query($createQuery);
        }
        
        public function tableExists ($tableName, $url = "") {
            $result = $this->conn->query("SHOW TABLES LIKE '$tableName'");
            if ($result->num_rows == 0 && !empty($url)) {
                echo '<script>
                    if(confirm("The Table [' . $tableName . '] is not set up.\n\nDo you wish to proceed to the setup page?")) {
                        window.location.href = "' . $url . '";
                    } else {
                        window.location.href = "' . BASEURL . '";
                    }
                </script>';
            }
            return $result->num_rows > 0;
        }

        public function closing() {
            $this->conn->close();
        }
    }
?>