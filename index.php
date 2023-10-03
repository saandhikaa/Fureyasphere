<?php
    require_once __DIR__ . "/shared/init.php";
    
    if (!session_id()) session_start();
    
    if (!(new Database())->databaseExists(DB_NAME)) {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<h2>Database "' . DB_NAME . '" not found, please create it.</h2>';
        die;
    }
    
    new App;
?>