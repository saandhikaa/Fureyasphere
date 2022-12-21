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
        $limit = $time + 60 * 60;
        $sector = rand(10,99);

        $codenamecheck = querying("SELECT * FROM blackhole WHERE codename LIKE '$codename'");
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

        $query = "INSERT INTO blackhole (id, codename, sector, path_, name_, limit_) VALUES ('$time', '$codename', '$sector', '$path', '$name', '$limit')";

        global $connection;
        mysqli_query($connection, $query);

        if (mysqli_affected_rows($connection)) {
            $message["DATA1"] = "NEW FILE THROWN\n\n"."$codename"."\n"."$name"."\n\n";
            $message["DATA2"] = "LAST " . count(querying("SELECT * FROM blackhole")) . " FILES IN BLACKHOLE";
            notification($message);
            return $sector;

        }else{
            echo "<script>alert('Database error')</script>";
            return false;
        }
    }

    function purging($id, $path){
        global $spacedir, $connection;
        
        unlink($spacedir.$path);
        mysqli_query($connection, "DELETE FROM blackhole WHERE id = $id");
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