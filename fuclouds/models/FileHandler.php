<?php
    class FileHandler {
        private $db;
        private $path = __DIR__ . "/../uploads/";
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function upload() {
            $time = time();
            $accepted = $this->slice();
            $filename = $this->handleDuplicate($accepted["name"]);
            
            for ($i = 0; $i < count($accepted["name"]); $i++) {
                if ($accepted["error"][$i] === 0) {
                    move_uploaded_file($accepted["tmp_name"][$i], $this->path . $time . "_" . $filename[$i]); 
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
        
        public function handleDuplicate ($array) {
            $counts = array_count_values($array);
        
            foreach ($array as $key => $filename) {
                if ($counts[$filename] > 1) {
                    $baseName = pathinfo($filename, PATHINFO_FILENAME);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $count = $counts[$filename];
                    $counts[$filename]--;
                    $newFilename = $baseName . '_' . sprintf('%02d', $count) . '.' . $extension;
                    $array[$key] = $newFilename;
                }
            }
        
            return $array;
        }
    }
?>