<?php
    $dbname = "space";
    $connection = mysqli_connect("localhost", "root", "", $dbname);
    
    $spacedir = "assets/";

    $API = "https://eoaq73qseezwdn9.m.pipedream.net";

    $server = $_SERVER['SERVER_NAME'] . "/rose2";
    $defaultuser = "Administrator";
    $defaultpass = "2022";
?>