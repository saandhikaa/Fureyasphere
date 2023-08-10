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
            $accepted = $this->slice();
            foreach ($accepted["error"] as $error) {
                if ($error != 0) {
                    return ["error" => "upload file failed"];
                }
            }
            
            $time = time();
            $owner = "anonymous";
            $codename = trim($_POST["codename"], "-");
            $key = $this->generateKey($codename);
            $filename = $this->handleDuplicate($accepted["name"]);
            
            for ($i = 0; $i < count($accepted["name"]); $i++) {
                $files[$i]["path"] = $time . "_" . $filename[$i];
                $files[$i]["name"] = $filename[$i];
                
                $values = [
                    "time" => $time, 
                    "owner" => $owner,
                    "codename" => $codename,
                    "key" => $key, 
                    "filename" => $filename[$i], 
                    "filesize" => $accepted["size"][$i], 
                    "duration" => 1, 
                    "available" => "YES"
                ];
                
                if ($this->insertDB($values) == 0 || !move_uploaded_file($accepted["tmp_name"][$i], $this->path . $files[$i]["path"])) {
                    return ["error" => "server error"];
                }
            }
            
            if (count($accepted["name"]) > 1) {
                $this->zipper($codename . "_" . $key . ".zip", $files);
            }
            
            return [
                "files" => $this->loadFiles($codename, $key), 
                "status" => [
                    "codename" => $codename,
                    "key" => $key
                ]
            ];
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
            $query = "SELECT codename_, key_, time_, filename_ FROM $this->table WHERE available_ = 'YES' AND time_ < :currentTime - (duration_ * :perseconds)";
            $this->db->query($query);
            $this->db->bind(':currentTime', $currentTime);
            $this->db->bind(':perseconds', $this->perseconds);
            $result = $this->db->result(true);
            
            // remove files
            foreach ($result as $entry) {
                $filepath = $this->path . $entry["time_"] . "_" . $entry["filename_"];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            
            if ($result) {
                $zippath = $this->path . $result[0]["codename_"] . "_" . $result[0]["key_"] . ".zip";
                if (file_exists($zippath)) {
                    unlink($zippath);
                }
            }
            
            // update VALUES at column available_ to NO
            $query = "UPDATE $this->table SET available_ = 'NO' WHERE time_ < :currentTime - (duration_ * :perseconds)";
            $this->db->query($query);
            $this->db->bind(':currentTime', $currentTime);
            $this->db->bind(':perseconds', $this->perseconds);
            $this->db->execute();
            $rowsAffected = $this->db->rowCount();
        }
        
        function download ($savedName, $filePath) {
            $fullPath = $this->path . $filePath;
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $savedName . '"');
            header('Content-Length: ' . filesize($fullPath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
        
            flush();
        
            readfile($fullPath);
        }
        
        public function zipper ($zipName, $files) {
            $zip = new ZipArchive();
            
            if ($zip->open($this->path . $zipName, ZipArchive::CREATE) === true) {
                foreach ($files as $file) {
                    if (file_exists($this->path . $file["path"])) {
                        $zip->addFile($this->path . $file["path"], $file["name"]);
                    }
                }
                $zip->close();
            }
        }
        
        public function loadFiles ($codename, $key) {
            $query = "SELECT * FROM $this->table WHERE codename_ = :codename AND key_ = :key AND available_ = 'YES'";
            $this->db->query($query);
            $this->db->bind(':codename', $codename);
            $this->db->bind(':key', $key);
            return $this->db->result(true);
        }
        
        public function generateKey ($codename) {
            $query = "SELECT key_ FROM $this->table WHERE codename_ = :codename AND available_ = 'YES' ";
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