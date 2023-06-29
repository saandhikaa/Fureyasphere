<?php
    // Query Execution Class
    class QueryExecution {
        private $connection;
    
        public function __construct(DatabaseConnection $connection) {
            $this->connection = $connection;
        }
    
        public function executeQuery($query, $return = FALSE) {
            $conn = $this->connection->getConnection();
    
            $result = $conn->query($query);
    
            if ($result === false) {
                die("Query execution failed: " . $conn->error);
            }
            
            if ($return) {
                $row = array();
                while ($row = $result->fetch_assoc()) {
                    $rows[] = $row;
                }
                return $rows;
            }
        }
    }
?>