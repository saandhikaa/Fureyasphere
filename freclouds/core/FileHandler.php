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
            $duration = 1;
            
            // regenerate key for duplicate codename
            $duplicateCodename = $this->queryExecution->executeQuery("SELECT * FROM cloudfiles WHERE codename_ LIKE '$codename'", TRUE);
            $takenKey = array_column($duplicateCodename, 'key_');
            while (in_array($key, $takenKey)) {
                $key = rand(10, 99);
            }
            
            foreach ($_FILES['file']['error'] as $index => $error) {
                if ($error == 0) {
                    $filename = $_FILES['file']['name'][$index];
                    $size = $_FILES['file']['size'][$index];
                    
                    // saving file
                    if (!move_uploaded_file($_FILES['file']['tmp_name'][$index], $this->path . $uploadtime . "_" . $filename)) {
                        echo '<script>alert("Failed to save file"); window.location.href = "";</script>';
                        exit;
                    }
                    
                    // create on database table cloudfiles
                    $query = "INSERT INTO cloudfiles (id, owner_, codename_, key_, filename_, size_, duration_) VALUES ('$uploadtime', '$owner', '$codename', '$key', '$filename', '$size', '$duration')";
                    if (!$this->queryExecution->executeQuery($query)) {
                        echo '<script>alert("Failed to insert into cloudfiles"); window.location.href = "";</script>';
                        exit;
                    }
                    
                    // create on database table logging
                    $query = "INSERT INTO logging (id, owner_, codename_, filename_, size_) VALUES ('$uploadtime', '$owner', '$codename', '$filename', '$size')";
                    if (!$this->queryExecution->executeQuery($query)) {
                        echo '<script>alert("Failed to insert into logging"); window.location.href = "";</script>';
                        exit;
                    }
                }
            }
        }
    }
?>