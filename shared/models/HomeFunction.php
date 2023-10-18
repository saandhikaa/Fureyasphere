<?php
    class HomeFunction {
        private $db;
        private $dataDir, $commentsPath;
        
        public function __construct(Database $database) {
            $this->dataDir = __DIR__ . "/../data-userfilesbox";
            $this->commentsPath = $this->dataDir . "/comments.json";
            
            if (!is_dir($this->dataDir)) {
                mkdir($this->dataDir, 0777, true);
            }
            if (!file_exists($this->commentsPath)) {
                file_put_contents($this->commentsPath, json_encode([]));
            }
            
            $this->db = $database;
        }
        
        public function addComment ($newComment) {
            $comments = json_decode(file_get_contents($this->commentsPath), true);
            $comments[] = $newComment;
            
            return file_put_contents($this->commentsPath, json_encode($comments));
        }
        
        public function loadComments() {
            $comments = json_decode(file_get_contents($this->commentsPath), true);
            
            $rows = [];
            foreach ($comments as $comment) {
                $rows[] = [
                    "time" => date('M d, Y', $comment['time']),
                    "username" => $this->db->fetching("SELECT username_ FROM users WHERE time_ = {$comment['uid']}")[0]["username_"],
                    "message" => $comment['message']
                ];
            }
            
            return $rows;
        }
    }
?>