<?php
    require "functions.php";
    
    $message["DATA1"] = "FILE HAVE BEEN PURGED\n\n";
    $limitation = querying("SELECT * FROM blackhole");
    for ($s = 0; $s < count($limitation); $s++){
        if ($limitation[$s]["limit_"] < time()) {
            purging($limitation[$s]["id"], $limitation[$s]["path_"]);
            $message["DATA1"] .= $limitation[$s]["codename"] . "\n" . $limitation[$s]["name_"] . "\n\n"; 
        }
    }
    $message["DATA2"] = "LAST " . count(querying("SELECT * FROM blackhole")) . " FILES IN BLACKHOLE";
    notification($message);

    $status = 0;
    if (isset($_POST["action"])){
        if ($_POST["action"] == "Throw!"){
            $codename = $_POST["codename"];
            $name = $_FILES['file']['name'];
            $refreshcheck = querying("SELECT * FROM blackhole WHERE codename LIKE '$codename' AND name_ LIKE '$name'");
            if (count($refreshcheck)) {
                header("Location: index.html");
                exit;
            }
            $sector = throwing($_POST);
            if ($sector) $status = 1;

        } elseif ($_POST["action"] == "Find!" || $_POST["action"] == "Download"){
            if ($_POST["action"] == "Download") collecting($_POST["path"], $_POST["name"]);
            $codename = rtrim($_POST['codename']);
            $sector = $_POST['sector'];
            $result = querying("SELECT * FROM blackhole WHERE codename LIKE '$codename' AND sector LIKE '$sector'");
            if ($result){
                $status = 2;
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
    <title>Document</title>
</head>
<body>
    <?php if ($status == 1): ?>
        <p>Success: <span style="color=red;"><?= $codename?></span> thrown into a Blackhole in Sector <span style="color=red;"><?=$sector?></span></p>
    
    <?php elseif ($status == 2): ?>
        <table>
            <tr>
                <td><?=$result[0]["name_"]?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="codename" value="<?=$codename?>">
                        <input type="hidden" name="sector" value="<?=$sector?>">
                        <input type="hidden" name="name" value="<?=$result[0]['name_']?>">
                        <input type="hidden" name="path" value="<?=$result[0]['path_']?>">
                        <input type="submit" name="action" value="Download">
                    </form>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <p>Invalid codename or sector / Missing file</p>
    <?php endif ?>
    
    <br><a href="index.html">back</a>
</body>
</html>