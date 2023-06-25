<?php
    // Autoloader function
    spl_autoload_register(function($className){
        $classFile = __DIR__ . '/core/' . $className . '.php';
        if (file_exists($classFile)) {
            require_once $classFile;
        }
    });
    
    // global variable
    $database = "cloud";
    
    // Create an instance of the DatabaseConnection class
    $dbConnection = new DatabaseConnection("0.0.0.0:3306", "root", "root", $database);
    
    // Connect to the database
    $dbConnection->connect();
    
    // Create an instance of the QueryExecution class
    $queryExecution = new QueryExecution($dbConnection);
?>

