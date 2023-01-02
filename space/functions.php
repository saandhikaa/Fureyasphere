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

    function throwing($value){
        $codename = htmlspecialchars(rtrim($value["codename"]));
        $time = time();
        $path = $time. "_" . $_FILES['file']['name'];
        $name = $_FILES['file']['name'];
        $size = $_FILES['file']['size'];
        $pathx = $_FILES['file']['tmp_name'];
        $sector = rand(10,99);

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

        if ($size > 40000000){
            echo "<script>alert('File size too big')</script>";
            return false;
        }

        global $spacedir;
        if (!move_uploaded_file($pathx, $spacedir.$path)){
            echo "<script>alert('No Blackhole detected')</script>";
            return false;
        }

        global $connection;
        $query = "INSERT INTO blackhole (id, codename_, sector_, path_, name_) VALUES ('$time', '$codename', '$sector', '$path', '$name')";
        mysqli_query($connection, $query);

        $query = "INSERT INTO logging (id, codename_, name_, size_) VALUES ('$time', '$codename', '$name', '$size')";
        mysqli_query($connection, $query);

        return $sector;
    }

    function purging($dir){
        global $spacedir, $connection;
        
        $limitation = querying("SELECT * FROM blackhole");
        if (!empty($limitation)){
            for ($s = 0; $s < count($limitation); $s++){
                if ($limitation[$s]["id"] + 60 * 60 < time()) {
                    $id = $limitation[$s]["id"];
                    $path = $dir . $spacedir . $limitation[$s]["path_"];
                    
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