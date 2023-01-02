<?php
    require "../functions.php";
    
    $tablelist = querying("SHOW TABLES");
    $tables = [];

    for ($i = 0; $i < count($tablelist); $i++){
        $tables[] = $tablelist[$i]["Tables_in_".$dbname];
    }

    if (!in_array("blackhole", $tables)){
        $query = "CREATE TABLE blackhole (
            id INT(10) PRIMARY KEY, 
            codename_ VARCHAR(20) NOT NULL, 
            sector_ VARCHAR(2) NOT NULL, 
            path_ VARCHAR(71) NOT NULL,
            name_ VARCHAR(50) NOT NULL
        )";

        if (mysqli_query($connection, $query)) echo "Blackhole create successfully!<br>";
    }

    if (!is_dir('../'.$spacedir)) mkdir('../'.$spacedir,0777,true);

    if (!in_array("traceline", $tables)){
        $query = "CREATE TABLE traceline (
            id INT(10) PRIMARY KEY,
            penname_ VARCHAR(20) NOT NULL,
            message_ VARCHAR(1023) NOT NULL
        )";

        if (mysqli_query($connection, $query)) echo "Traceline create successfully!<br>";
    }

    if (!in_array("spaceship", $tables)){
        $query = "CREATE TABLE spaceship (
            id INT(10) PRIMARY KEY,
            username_ VARCHAR(20) NOT NULL,
            password_ VARCHAR(255) NOT NULL,
            level_ INT(2) NOT NULL
        )";

        if (mysqli_query($connection, $query)) echo "Spaceship create successfully!<br>";
    }
    
    if (!in_array("logging", $tables)){
        $query = "CREATE TABLE logging (
            id INT(10) PRIMARY KEY,
            codename_ VARCHAR(20) NOT NULL,
            name_ VARCHAR(255) NOT NULL,
            size_ varchar(10) NOT NULL
        )";

        if (mysqli_query($connection, $query)) echo "Logline create successfully!<br>";
    }

    if (!in_array("changelog", $tables)){
        $query = "CREATE TABLE changelog (
            id INT(10) PRIMARY KEY,
            version_ VARCHAR(10) NOT NULL,
            update_ VARCHAR(255) NOT NULL,
            maintainer_ VARCHAR(20) NOT NULL
        )";

        if (mysqli_query($connection, $query)) echo "changelog create successfully!<br>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLACKHOLE: Setup</title>
</head>
<body>
    <br>
    <a href="../">BLACKHOLE</a>
</body>
</html>