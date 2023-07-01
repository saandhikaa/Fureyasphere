<?php
    spl_autoload_register(function($className){
        $classFile = __DIR__ . '/../core/' . $className . '.php';
        if (file_exists($classFile)) {
            require_once $classFile;
        }
    });
    
    require_once __DIR__ . "/../../shared/include/init.php";
    
    $handler = new FileHandler();
?>