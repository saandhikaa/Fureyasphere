<?php
    class FileHandler {
        private $db;
        
        public function __construct() {
            $this->db = new Database;
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