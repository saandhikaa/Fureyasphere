<?php
    class FileHandler {
        private $db;
        private $path = __DIR__ . "/../uploads/";
        private $table = "uploads";
        private $perseconds = 24 * 60 * 60;
        
        public function __construct() {
            $this->db = new Database;
        }
        
        public function upload() {
            $time = time();
            $owner = "anonymous";
            $key = $this->generateKey($_POST["codename"]);
            
            $accepted = $this->slice();
            $filename = $this->handleDuplicate($accepted["name"]);
            
            for ($i = 0; $i < count($accepted["name"]); $i++) {
                $values = [
                    "time" => $time, 
                    "owner" => $owner,
                    "codename" => $_POST["codename"],
                    "key" => $key, 
                    "filename" => $filename[$i], 
                    "filesize" => $accepted["size"][$i], 
                    "duration" => 1, 
                    "available" => "YES"
                ];
                
                if ($accepted["error"][$i] === 0) {
                    if ($this->insertDB($values) > 0) {
                        echo "inserted.";
                        if (move_uploaded_file($accepted["tmp_name"][$i], $this->path . $time . "_" . $filename[$i])) {
                            echo "saved<br>";
                        }
                    }
                }
            }
        }
        
        // insert values into database
        public function insertDB ($data) {
            $query = "INSERT INTO $this->table (time_, owner_, codename_, key_, filename_, filesize_, duration_, available_) VALUES (:time, :owner, :codename, :key, :filename, :filesize, :duration, :available)";
    
            $this->db->query($query);
            $this->db->bind(':time', $data['time']);
            $this->db->bind(':owner', $data['owner']);
            $this->db->bind(':codename', $data['codename']);
            $this->db->bind(':key', $data['key']);
            $this->db->bind(':filename', $data['filename']);
            $this->db->bind(':filesize', $data['filesize']);
            $this->db->bind(':duration', $data['duration']);
            $this->db->bind(':available', $data['available']);
            
            $this->db->execute();
            
            return $this->db->rowCount();
        }
        
        public function autoRemove() {
            $currentTime = time();
            $query = "SELECT time_, filename_ FROM $this->table WHERE available_ = 'YES' AND time_ < :currentTime - (duration_ * :perseconds)";
            $this->db->query($query);
            $this->db->bind(':currentTime', $currentTime);
            $this->db->bind(':perseconds', $this->perseconds);
            $result = $this->db->result(true);
        }
        
        public function generateKey ($codename) {
            $query = "SELECT key_ FROM $this->table WHERE codename_ = :codename";
            $this->db->query($query);
            $this->db->bind(':codename', $codename);
            $result = $this->db->result(true);
            
            $keys = array_column($result, 'key_');
            $keys = array_unique($keys);
            $keys = array_values($keys);
            
            do {
                $key = rand(10, 99);
            } while (in_array($key, $keys));
            
            return $key;
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
        
        // rename (add numbering) for duplicate filename
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