<?php
    // Autoloader function
    spl_autoload_register(function($className){
        $classFile = __DIR__ . '/core/' . $className . '.php';
        if (file_exists($classFile)) {
            require_once $classFile;
        }
    });
    
    // load config
    require_once __DIR__ . "/config/config.php";
?>