<?php
    require_once __DIR__ . "/shared/init.php";
    
    if (!session_id()) {
        session_start();
    }
    
    $database = new Database;
    
    new App($database);
    
    $database->closing();
?>