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
        
        public function fetching ($query, $params = []) {
            $stmt = $this->querying($query, $params);
            $result = $stmt->get_result();
            $rows = [];
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $stmt->close();
            return $rows;
        }
        
        public function executing ($query, $params = []) {
            $stmt = $this->querying($query, $params);
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            return $affected_rows > 0;
        }

        public function dropAndCreateTable ($tableName, $createTableSQL) {
            return $this->executing("DROP TABLE IF EXISTS {$tableName}; {$createTableSQL}");
        }
        
        public function tableExists ($tableName, $url = "") {
            if (count($this->fetching("SHOW TABLES LIKE '$tableName'")) == 0 && !empty($url)) {
                echo '<script>
                    if(confirm("The Table [' . htmlspecialchars($tableName) . '] is not set up.\n\nDo you wish to proceed to the setup page?")) {
                        window.location.href = "' . htmlspecialchars($url) . '";
                    } else {
                        window.location.href = "' . BASEURL . '";
                    }
                </script>';
                return false;
            }
            return true;
        }
        
        public function closing() {
            $this->conn->close();
        }
    }
?>