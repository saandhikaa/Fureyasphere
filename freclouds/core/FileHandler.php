<?php
    class FileHandler {
        private $queryExecution; 
        private $path = __DIR__ . "/../uploads/";
        
        public function __construct() {
            global $queryExecution;
            $this->queryExecution = $queryExecution;
        }
        
        public function upload() {
            // get data for database value
            $uploadtime = time();
            $owner = "anonymous";
            $codename = htmlspecialchars(rtrim($_POST["codename"]));
            $key = rand(10,99);
            $filename = $_FILES["file"]["name"];
            $size = $_FILES["file"]["size"];
            $duration = 1;
            
            // regenerate key for duplicate codename
            $duplicateCodename = $this->queryExecution->executeQuery("SELECT * FROM cloudfiles WHERE codename_ LIKE '$codename'", TRUE);
            $takenKey = array_column($duplicateCodename, 'key_');
            while (in_array($key, $takenKey)) {
                $key = rand(10, 99);
            }
            
            // processing file
            if ($_FILES['file']['error'] != 0) {
                echo '<script>alert("File upload failed: error code (' . $_FILES['file']['error'] . ')"); window.location.href = "";</script>';
                exit; 
            }
            
            // saving file
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $this->path . $uploadtime . "_" . $_FILES["file"]["name"])) {
                echo '<script>alert("Failed to save file"); window.location.href = "";</script>';
                exit;
            }
            
            // create on database table cloudfiles
            $query = "INSERT INTO cloudfiles (id, owner_, codename_, key_, filename_, size_, duration_) VALUES ('$uploadtime', '$owner', '$codename', '$key', '$filename', '$size', '$duration')";
            $this->queryExecution->executeQuery($query);
            
            // create on database table logging
            $query = "INSERT INTO logging (id, owner_, codename_, filename_, size_) VALUES ('$uploadtime', '$owner', '$codename', '$filename', '$size')";
            $this->queryExecution->executeQuery($query);
        }
    }
?>