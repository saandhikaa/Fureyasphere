<?php
    $dbhost = "0.0.0.0:3306";
    $dbuser = "root";
    $dbpass = "root";
    $dbname = "space";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    $spacedir = "assets/";

    $API = "https://eoaq73qseezwdn9.m.pipedream.net";

    $server = $_SERVER['SERVER_NAME'] . "/rose";
    $defaultuser = "Administrator";
    $defaultpass = "2022";
?>