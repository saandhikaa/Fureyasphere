<?php
    require "connections.php";
    
    function querying($value){
        global $connection;
        $result = mysqli_query($connection, $value);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function collecting($path,$name){
        global $spacedir;
        $value = $spacedir.$path;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Content-Length: '.filesize($value));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        flush();

        readfile($value);
    }

    function dropping($value){
        $codename = htmlspecialchars(rtrim($value["codename"]));
        $time = time();
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $pathx = $_FILES['file']['tmp_name'];
        $sector = rand(10,99);
        $savedname = $time. "_" . $_FILES['file']['name'];

        $codenamecheck = querying("SELECT * FROM blackhole WHERE codename_ LIKE '$codename'");
        for ($s = 0; $s < count($codenamecheck); $s++){
            if ($sector == $codenamecheck[$s]["sector"]){
                $sector = rand(10,99);
                $s = 0;
            }
        }
        
        if ($_FILES['file']['error'] === 4){
            echo "<script>alert('Error')</script>";
            return false;
        }

        if ($size > 41943040){
            echo "<script>alert('File size too big')</script>";
            return false;
        }
        if ($size > 1048576) $size = number_format($size/1048576,1) . ' MB';
        elseif ($size > 1024) $size = number_format($size/1024,1) . ' KB';
        else $size = $size . ' bytes';

        global $spacedir;
        if (!move_uploaded_file($pathx, "../".$spacedir.$savedname)){
            echo "<script>alert('No Blackhole detected')</script>";
            return false;
        }

        if (!empty($_SESSION["login"])){
            $userid = $_SESSION["login"];
            $owner = querying("SELECT username_ FROM spaceship WHERE id = '$userid'")[0]["username_"];
            $limit = 8760;
        }else{
            $owner = "none";
            $limit = 1;
        }

        global $connection;
        $query = "INSERT INTO blackhole (id, codename_, sector_, savedname_, name_, hours_, owner_, size_) VALUES ('$time', '$codename', '$sector', '$savedname', '$name', '$limit', '$owner', '$size')";
        mysqli_query($connection, $query);

        $query = "INSERT INTO logging (id, owner_, codename_, name_, size_) VALUES ('$time',  '$owner', '$codename', '$name', '$size')";
        mysqli_query($connection, $query);

        return $sector;
    }

    function purging($dir){
        global $spacedir, $connection;
        
        $limitation = querying("SELECT * FROM blackhole");
        if (!empty($limitation)){
            for ($s = 0; $s < count($limitation); $s++){
                if ($limitation[$s]["id"] + $limitation[$s]["hours_"] * 60 * 60 < time()) {
                    $id = $limitation[$s]["id"];
                    $path = $dir . $spacedir . $limitation[$s]["savedname_"];
                    
                    unlink($path);
                    mysqli_query($connection, "DELETE FROM blackhole WHERE id = $id");
                }
            }
        }
    }

    function traceline($value){
        $time = time();
        $penname = htmlspecialchars(rtrim($value["penname"]));
        $message = htmlspecialchars($value["message"]);

        global $connection;
        $query = "INSERT INTO traceline (id, penname_, message_) VALUES ('$time', '$penname', '$message')";
        mysqli_query($connection, $query);

        notification(array("notification"=>"NEW COMMENT\n\n".$penname."\n".$message."\n\nhttps:saandhikaa.github.io/rose\n"));
    }

    function notification($value){
        $option = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => "POST",
                'content' => http_build_query($value)
            )
        );

        global $API;
        $context = stream_context_create($option);
        file_get_contents($API, false, $context);
    }
?>