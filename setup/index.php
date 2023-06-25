<?php
    require_once __DIR__ . "/../init.php";
    
    $directory = __DIR__ . "/../notes";
    
    // Create the directory
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
        echo "Directory created successfully.<br>";
    } else {
        echo "Directory already exists.<br>";
    }
?>