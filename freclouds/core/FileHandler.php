<?php
    class FileHandler {
        private $queryExecution; 
        private $path = __DIR__ . "/../uploads/";
        
        public function __construct() {
            global $queryExecution;
            $this->queryExecution = $queryExecution;
        }
        
        public function upload () {
            $uploadtime = time();
            
            if ($_FILES['file']['error'] != 0) {
                echo '<script>alert("File upload failed: error code (' . $_FILES['file']['error'] . ')"); window.location.href = "";</script>';
                exit; 
            }
            
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $this->path . $uploadtime . "_" . $_FILES["file"]["name"])) {
                echo '<script>alert("Failed to save file"); window.location.href = "";</script>';
                exit;
            }
        }
    }
?>