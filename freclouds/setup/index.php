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
    
    // removing database, files and session
    if (isset($_POST["action"])){
        if ($_POST["action"] == "RESET"){
            for ($i = 0; $i < count($tables); $i++){
                mysqli_query($connection, "DROP TABLE " . $tables[$i]);
            }

            if (isset($_POST['all'])){
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
            }
            
            session_unset();
            session_destroy();
            header("Location: ../setup/");
            exit;
        }
    }

    // creating directory and database
    if (!is_dir('../'.$spacedir)) {
        mkdir('../'.$spacedir,0777,true);
        echo "Directory create sucessfuly!<br><br>";
    }

    if (!in_array("blackhole", $tables)){
        $query = "CREATE TABLE blackhole (
            id INT(10) PRIMARY KEY, 
            owner_ VARCHAR(20) NOT NULL,
            codename_ VARCHAR(20) NOT NULL, 
            sector_ VARCHAR(2) NOT NULL, 
            name_ VARCHAR(50) NOT NULL,
            savedname_ VARCHAR(71) NOT NULL,
            size_ VARCHAR(11) NOT NULL,
            hours_ INT(4) NOT NULL
        )";
        if (mysqli_query($connection, $query)) echo "Blackhole create sucessfully!<br><br>";
    }

    if (!in_array("logging", $tables)){
        $query = "CREATE TABLE logging (
            id INT(10) PRIMARY KEY,
            owner_ VARCHAR(20) NOT NULL,
            codename_ VARCHAR(20) NOT NULL,
            name_ VARCHAR(255) NOT NULL,
            size_ VARCHAR(11) NOT NULL
        )";
        if (mysqli_query($connection, $query)) echo "Logline create sucessfully!<br><br>";
    }

    if (!in_array("traceline", $tables)){
        $query = "CREATE TABLE traceline (
            id INT(10) PRIMARY KEY,
            penname_ VARCHAR(20) NOT NULL,
            message_ VARCHAR(1023) NOT NULL
        )";
        if (mysqli_query($connection, $query)) echo "Traceline create sucessfully!<br><br>";
    }

    if (!in_array("spaceship", $tables)){
        $query = "CREATE TABLE spaceship (
            id INT(10) PRIMARY KEY,
            username_ VARCHAR(20) NOT NULL,
            password_ VARCHAR(255) NOT NULL,
            level_ INT(2) NOT NULL
        )";
        if (mysqli_query($connection, $query)) echo "Spaceship create sucessfully!<br><br>";
        
        $time = time();
        $password = password_hash($defaultpass, PASSWORD_DEFAULT);
        mysqli_query($connection, "INSERT INTO spaceship (id, username_, password_, level_) VALUES ('$time', '$defaultuser', '$password', 1)");
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
        .menu input[type="submit"]{width: 100px;}
        .menu td{padding: 5px 2px;}
    </style>
</head>

<body>    
    <table class="menu">
        <tr>
            <form action="" method="post"> 
                <td><input type="submit" name="action" value="RESET"></td>
                <td><input type="checkbox" name="all"> Delete Files</td>
            </form>
        </tr>
        <tr><td><a href="../"><input type="submit" value="BLACKHOLE"></a></td></tr>
    </table>
    <br>

    <?php for ($i = 0; $i < count($tables); $i++): ?><hr>
        <h3><?=$tables[$i]?></h3>
        <div style="display: flex;">
            <?php for ($ii = 0; $ii < count($headers[$i]); $ii++): ?>
                <div style="margin: 0 10px;"><?=$headers[$i][$ii]?></div>
            <?php endfor ?>
        </div><br>
    <?php endfor ?>

    <br><br><br><br><br><br><br><br>

    <div class="footer">
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <table>
            <tr><td><a href="https://buymeacoffee.com/vanila" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" height="41" width="174"></a></td></tr>
            <tr><td><a class="github-button" href="https://github.com/saandhikaa" data-size="large" aria-label="Follow @saandhikaa on GitHub">Follow @saandhikaa</a></td></tr>
        </table>

        <p class="copyright">Copyright 2023 - <?= $server ?> - All Rights Reserved</p>
    </div>
</body>
</html>