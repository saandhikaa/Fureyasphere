<?php
    require "../functions.php";

    session_start();
    
    // mysqli_query($connection, "ALTER TABLE blackhole ADD COLUMN owner_ VARCHAR(20) NOT NULL AFTER limit_");

    $headerlist = [];
    $headers = [];
    $tables = [];
    
    $tablelist = querying("SHOW TABLES");
    for ($i = 0; $i < count($tablelist); $i++){
        $tables[] = $tablelist[$i]["Tables_in_".$dbname];
        $headerlist = querying("SHOW COLUMNS FROM " . $tables[$i]);
        for ($ii = 0; $ii < count($headerlist); $ii++){
            $headers[$i][] = $headerlist[$ii]["Field"];
        }
    }    

    if (!empty($tablelist)){
        $user = querying("SELECT * FROM spaceship");
        if (!empty($user)){
            if (!isset($_SESSION["login"])){
                header("Location: ../spaceship/login.php?from=setup");
            }
        }
    }
    
    if (isset($_POST["action"])){
        if ($_POST["action"] == "RESET"){
            $dir = "../" . $spacedir;
            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file){
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                }else{
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
            for ($i = 0; $i < count($tables); $i++){
                mysqli_query($connection, "DROP TABLE " . $tables[$i]);
            }
            session_unset();
            session_destroy();
            header("Location: ../setup/");
            exit;
        }
    }

    
    if (!is_dir('../'.$spacedir)) mkdir('../'.$spacedir,0777,true);

    if (!in_array("blackhole", $tables)){
        $query = "CREATE TABLE blackhole (
            id INT(10) PRIMARY KEY, 
            codename_ VARCHAR(20) NOT NULL, 
            sector_ VARCHAR(2) NOT NULL, 
            path_ VARCHAR(71) NOT NULL,
            name_ VARCHAR(50) NOT NULL,
            limit_ INT(4) NOT NULL,
            owner_ VARCHAR(20) NOT NULL
        )";
        if (mysqli_query($connection, $query)) echo "Blackhole create successfully!<br>";
    }

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
        
        $time = time();
        $password = password_hash($defaultpass, PASSWORD_DEFAULT);
        mysqli_query($connection, "INSERT INTO spaceship (id, username_, password_, level_) VALUES ('$time', '$defaultuser', '$password', 1)");
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

    if (empty($tablelist)){
        $tablelist = querying("SHOW TABLES");
        for ($i = 0; $i < count($tablelist); $i++){
            $tables[] = $tablelist[$i]["Tables_in_".$dbname];
            $headerlist = querying("SHOW COLUMNS FROM " . $tables[$i]);
            for ($ii = 0; $ii < count($headerlist); $ii++){
                $headers[$i][] = $headerlist[$ii]["Field"];
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETUP</title>
    <link rel="stylesheet" href="../styles.css">

    <style>
        .menu{display: flex;}
        .item{margin: 10px;}
        .item input:hover{cursor: pointer;}
    </style>
</head>

<body>    
    <div class="menu">
        <form class="item" action="" method="post"> 
            <input type="submit" name="action" value="RESET">
        </form>
        <a class="item" href="../"><input type="submit" value="BLACKHOLE"></a>
    </div>
    <br><hr>

    <?php for ($i = 0; $i < count($tables); $i++): ?>
        <h3><?=$tables[$i]?></h3>
        <div style="display: flex;">
            <?php for ($ii = 0; $ii < count($headers[$i]); $ii++): ?>
                <div style="margin: 0 10px;"><?=$headers[$i][$ii]?></div>
            <?php endfor ?>
        </div><br><hr>
    <?php endfor ?>
    
    <br><br><br><br><br>

    <div class="footer"><br>
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <table>
            <tr>
                <td style="padding: 0 10px;"><a href="https://buymeacoffee.com/vanila" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="28" width="146"></a></td>
                <td style="padding: 0 10px;"><a class="github-button" href="https://github.com/saandhikaa" data-size="large" aria-label="Follow @saandhikaa on GitHub">Follow @saandhikaa</a>            </td>
            </tr>
        </table>
                    
        <p class="copyright">Copyright 2023 - <?= $_SERVER['SERVER_NAME'] ?> - All Rights Reserved</p>
    </div>
</body>
</html>