<?php
    class FileHandler {
        private $db;
        private $path = __DIR__ . "/../uploads/";
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function upload() {
            $accepted = $this->slice();
            print_r($accepted);
            
            for ($i = 0; $i < count($accepted["name"]); $i++) {
                if ($accepted["error"][$i] === 0) {
                    move_uploaded_file($accepted["tmp_name"][$i], $this->path . $accepted["name"][$i]); 
                }
            }
        }
        
        // cut canceled file
        public function slice() {
            $sliced = [];
            foreach ($_FILES['file']['name'] as $index => $file) {
                if (in_array($file, $_POST['post'])) {
                    $sliced['name'][] = $_FILES['file']['name'][$index];
                    $sliced['type'][] = $_FILES['file']['type'][$index];
                    $sliced['size'][] = $_FILES['file']['size'][$index];
                    $sliced['error'][] = $_FILES['file']['error'][$index];
                    $sliced['tmp_name'][] = $_FILES['file']['tmp_name'][$index];
                }
            }
            return $sliced;
        }
    }
?>