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
            
            if ($newComment["replied"] == "0") {
                unset($newComment["replied"]);
                $newComment["replies"] = [];
                $comments[] = $newComment;
            } else {
                $reply = explode("-", $newComment["replied"]);
                foreach ($comments as &$comment) {
                    if ($comment['uid'] == $reply[0] && $comment['time'] == $reply[1]) {
                        unset($newComment["replied"]);
                        $comment["replies"][] = $newComment;
                    }
                }
                unset($comment);
            }
            
            return file_put_contents($this->commentsPath, json_encode($comments));
        }
        
        public function loadComments() {
            $comments = json_decode(file_get_contents($this->commentsPath), true);
            
            $rows = [];
            foreach ($comments as $comment) {
                $replies = [];
                foreach ($comment["replies"] as $reply) {
                    $username = $this->db->fetching("SELECT username_ FROM users WHERE time_ = ?", [$reply['uid']]);
                    $replies[] = [
                        "id" => $reply["uid"] . "-" . $reply["time"],
                        "time" => date('M d, Y', $reply['time']),
                        "username" => $username ? $username[0]["username_"] : "deleted user",
                        "message" => self::sanitize_html($reply['message'])
                    ];
                }
                
                $username = $this->db->fetching("SELECT username_ FROM users WHERE time_ = ?", [$comment['uid']]);
                $rows[] = [
                    "id" => $comment["uid"] . "-" . $comment["time"],
                    "time" => date('M d, Y', $comment['time']),
                    "username" => $username ? $username[0]["username_"] : "deleted user",
                    "message" => self::sanitize_html($comment['message']),
                    "replies" => $replies
                ];
            }
            
            return $rows;
        }
        
        public static function sanitize_html($dirty_html) {
            $allowed_tags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'b', 'i'];
            $escaped_html = htmlspecialchars($dirty_html);
            
            foreach ($allowed_tags as $tag) {
                $escaped_html = str_replace("&lt;".$tag."&gt;", "<".$tag.">", $escaped_html);
                $escaped_html = str_replace("&lt;/".$tag."&gt;", "</".$tag.">", $escaped_html);
            }
            
            return nl2br($escaped_html);
        }
    }
?>