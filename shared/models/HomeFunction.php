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
                $commentId = explode("-", $newComment["replied"]);
                if (isset($newComment["mention"])) {
                    foreach ($comments as &$comment) {
                        foreach ($comment["replies"] as &$reply) {
                            if ($reply['uid'] == $commentId[0] && $reply['time'] == $commentId[1]) {
                                unset($newComment["mention"]);
                                $comment["replies"][] = $newComment;
                                break 2;
                            }
                        }
                    }
                } else {
                    foreach ($comments as &$comment) {
                        if ($comment['uid'] == $commentId[0] && $comment['time'] == $commentId[1]) {
                            unset($newComment["replied"]);
                            $comment["replies"][] = $newComment;
                            break;
                        }
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
                    $mention = false;
                    if (isset($reply["replied"])) {
                        $commentId = explode("-", $reply["replied"]);
                        $mention = [$this->db->fetching("SELECT username_ FROM users WHERE time_ = ?", [$commentId[0]])[0]["username_"], $reply["replied"]];
                    }
                    
                    $replies[] = [
                        "id" => $reply["uid"] . "-" . $reply["time"],
                        "time" => date('M d, Y', $reply['time']),
                        "username" => $username ? $username[0]["username_"] : "deleted user",
                        "message" => self::sanitize_html($reply['message']),
                        "mention" => $mention
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
            $allowed_tags = ['b', 'i'];
            $escaped_html = htmlspecialchars($dirty_html);
            
            foreach ($allowed_tags as $tag) {
                $escaped_html = str_replace("&lt;".$tag."&gt;", "<".$tag.">", $escaped_html);
                $escaped_html = str_replace("&lt;/".$tag."&gt;", "</".$tag.">", $escaped_html);
            }
            
            return nl2br($escaped_html);
        }
    }
?>