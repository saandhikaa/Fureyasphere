<?php
    require "functions.php";
    
    purging("");

    if (isset($_POST["action"])){
        if ($_POST["action"] == "Throw!"){
            $codename = $_POST["codename"];
            $name = $_FILES['file']['name'];
            $refreshcheck = querying("SELECT * FROM blackhole WHERE codename_ LIKE '$codename' AND name_ LIKE '$name'");
            if (count($refreshcheck)) {
                $sector = $refreshcheck[0]['sector_'];
            }else{
                $sector = throwing($_POST);
            }

        } elseif ($_POST["action"] == "Find!" || $_POST["action"] == "Download"){
            if ($_POST["action"] == "Download") collecting($_POST["path"], $_POST["name"]);
            $codename = rtrim($_POST['codename']);
            $sector = $_POST['sector'];
            $result = querying("SELECT * FROM blackhole WHERE codename_ LIKE '$codename' AND sector_ LIKE '$sector'");

        } elseif ($_POST["action"] == "Send comment!"){
            traceline($_POST);
            header("Location: traceline/");
        }
    }else{
        header("Location: ../space");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESULT</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Source Sans Pro', sans-serif;">
    <?php if ($_POST["action"] == "Throw!"): ?>
        <p>Success: <span style="color: green; font-weight: bold;"><?= $codename?></span> thrown into a Blackhole in Sector <span style="color: green; font-weight: bold;"><?=$sector?></span></p>
    
    <?php elseif ($_POST["action"] == "Find!"): ?>
        <?php if (!empty($result)): ?>
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
    <?php endif ?>
    
    <br><a href="../space">back</a>
</body>
</html>