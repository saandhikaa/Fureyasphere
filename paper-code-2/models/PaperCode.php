<?php
    class PaperCode {
        public function save($note) {
            file_put_contents($note['path'].time()."_".$note['title'].".txt", $note['field'], FILE_APPEND | LOCK_EX);
        }
        
        public function openlist($path) {
            $notes = scandir($path);
            for ($i = 0; $i < count($notes); $i++) {
                if ($notes[$i] === '.' || $notes[$i] === '..' || !is_file($notes[$i])){
                    unset($notes[$i]);
                }
            }
            $notes = array_values($notes);
            
            $clear = array();
            for ($i = 0; $i < count($notes); $i++) {
                $parts = explode("_", $notes);
                $clear[$i] = array($notes[$i], $parts[0], $parts[1]);
            }
            return $clear;
        }
        
        public function open($dir) {
            return nl2br(file_get_contents($dir));
        }
        
        public function remove($dir) {
            unlink($dir);
        }
    }
?>