<?php
    class Database extends Controller {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;
        
        private $dbh, $statement;
        
        public function __construct() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $option = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
                $this->query("USE " . $this->dbname);
                $this->execute();
            } catch (PDOException $e) {
                $data = ["title" => "Database Error"];
                
                $errorCode = $e->getCode();
                switch ($errorCode) {
                    case 1049:
                        $data["strong"] = "Error: Unknown database.";
                        $data["normal"] = "Please check the database name, connection settings, or create the database if it does not exist.";
                        break;
                    case 1044:
                        $data["strong"] = "Error: Access denied for user.";
                        $data["normal"] = "Please check the username, password, connection settings, or the user's permissions.";
                        break;
                    case 2002:
                        $data["strong"] = "Error: Connection refused.";
                        $data["normal"] = "Please check the database server, host, port, or connection settings.";
                        break;
                    case 1045:
                        $data["strong"] = "Error: Access denied for user.";
                        $data["normal"] = "Please check the username, password, connection settings, or the user's permissions.";
                        break;
                    case 42000:
                        $data["strong"] = "Error: SQL syntax error or access violation (42000).";
                        $data["normal"] = "Please check the SQL syntax, database name, connection settings, or create the database if it does not exist.";
                        break;
                    default:
                        $data["strong"] = "An error occurred:" . $e->getCode();
                        $data["normal"] = $e->getMessage();
                        break;
                }
                
                $this->view(basename(dirname(__DIR__)), "shares/error", $data);
                die;
            }
        }
        
        public function query ($query) {
            $this->statement = $this->dbh->prepare($query);
        }
        
        public function bind ($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                        
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                        
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            
            $this->statement->bindValue($param, $value, $type);
        }
        
        public function execute() {
            return $this->statement->execute();
        }
        
        public function result ($all = false) {
            $this->execute();
            return $all ? $this->statement->fetchAll(PDO::FETCH_ASSOC) : $this->statement->fetch(PDO::FETCH_ASSOC);
        }
        
        public function rowCount() {
            return $this->statement->rowCount();
        }
    }
?>