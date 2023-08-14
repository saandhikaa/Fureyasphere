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
            $accepted = $this->slice($_POST['post']);
            $filename = $this->handleDuplicate($accepted["name"]);
            $codename = trim($_POST["codename"], "-");
            $repost = $this->handleRePost($codename, $filename);
            
            // rePost variable handling
            if (!empty($repost)) {
                $prevtime = $repost["time"];
                $key = $repost["key"];
                
                if (isset($repost["diff"])) {
                    $accepted = $this->slice($repost["diff"]);
                    $filename = $this->handleDuplicate($accepted["name"]);
                }
            } else {
                $key = $this->generateKey($codename);
            }
            
            // uploading files, check condition: 1 new upload, 2 resubmit form, 3 new file for previous upload. 
            if (empty($repost) || (!empty($repost) && isset($repost["diff"]))) {
                foreach ($accepted["error"] as $error) {
                    if ($error != 0) {
                        return ["error" => "upload file failed"];
                    }
                }
                
                // save file to cloud and database
                $time = time();
                for ($i = 0; $i < count($accepted["name"]); $i++) {
                    $files[$i]["path"] = $time . "_" . $filename[$i];
                    $files[$i]["name"] = $filename[$i];
                    
                    $values = [
                        "time" => $time, 
                        "owner" => "anonymous",
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
                
                // update existing file if there's new file for previous uploaded
                if (isset($repost["diff"])) {
                    $this->updateExistingFiles($codename, $key, $time, $prevtime);
                }
                
                // create zip for multiple files
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
        
        public function updateExistingFiles ($codename, $key, $time, $prevtime) {
            // update time_ in table database
            $query = "UPDATE $this->table SET time_ = :newTime WHERE codename_ = :codename AND key_ = :key AND time_ != :newTime";
            
            $this->db->query($query);
            $this->db->bind(':newTime', $time);
            $this->db->bind(':codename', $codename);
            $this->db->bind(':key', $key);
            
            $this->db->execute();
            
            // Check if any rows are updated
            if ($this->db->rowCount() > 0) {
                $filteredFiles = [];
                $files = scandir($this->path);
                
                // get list of must update file in cloud
                foreach ($files as $file) {
                    if (strpos($file, '_') !== false) {
                        $prefix = substr($file, 0, strpos($file, '_'));
                        if ($prefix == $prevtime) {
                            $filteredFiles[] = $file;
                        }
                    }
                }
                
                // rename filtered files in the cloud to use new prefix
                foreach ($filteredFiles as $file) {
                    $oldPath = $this->path . $file;
                    $newName = $time . substr($file, strpos($file, '_')); // Keep the rest of the filename after the underscore
                    $newPath = $this->path . $newName;
                
                    rename($oldPath, $newPath);
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
        
        // update availability file = NO and remove file that passed the limit
        public function autoRemove() {
            // get list of file that passed the limit
            $currentTime = time();
            $query = "SELECT codename_, key_, time_, filename_ FROM $this->table WHERE available_ = 'YES' AND time_ < :currentTime - (duration_ * :perseconds)";
            $this->db->query($query);
            $this->db->bind(':currentTime', $currentTime);
            $this->db->bind(':perseconds', $this->perseconds);
            $result = $this->db->result(true);
            
            // remove file
            foreach ($result as $entry) {
                $filepath = $this->path . $entry["time_"] . "_" . $entry["filename_"];
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
                
                $zippath = $this->path . $entry["codename_"] . "_" . $entry["key_"] . ".zip";
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
        
        // get list of file by codename and key
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
        
        // cut canceled $_FILES by given argument
        public function slice($accepted) {
            $sliced = [];
            foreach ($_FILES['file']['name'] as $index => $file) {
                if (in_array($file, $accepted)) {
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
        
        // handling for submitted form, check for codename and file
        public function handleRePost ($codename, $files) {
            $query = "SELECT filename_, key_, time_ FROM $this->table WHERE codename_ = :codename AND available_ = 'YES' ";
            $this->db->query($query);
            $this->db->bind(':codename', $codename);
            $result = $this->db->result(true);
            
            $time = [];
            $listed = [];
            $output = [];
            
            // create array for files and time in cloud
            foreach ($result as $item) {
                $listed[$item["key_"]][] = $item["filename_"];
                $time[$item["key_"]] = $item["time_"];
            }
            
            foreach ($listed as $key => $cloud) {
                // Check if all files on the cloud are in the form
                if (empty(array_diff($cloud, $files))) {
                    $output = [
                        "time" => $time[$key], 
                        "key" => $key
                    ];
                    
                    // Check if there is a new file from the form
                    if (!empty($diff = array_diff($files, $cloud))) {
                        $output["diff"] = $diff;
                    }
                } 
            }
            
            return $output;
        }
    }
?>