<?php
    require "../functions.php";
    session_start();

    purging("");

    if (isset($_GET["find"])){
        $filename = $_GET["find"];
        $row = querying("SELECT * FROM blackhole WHERE savedname_ = '$filename'")[0];

    } elseif (isset($_POST["action"])){
        if ($_POST["action"] == "Drop!"){
            $codename = $_POST["codename"];
            $name = $_FILES['file']['name'];
            $refreshcheck = querying("SELECT * FROM blackhole WHERE codename_ LIKE '$codename' AND name_ LIKE '$name'");
            if (count($refreshcheck)) {
                $sector = $refreshcheck[0]['sector_'];
                $result = $refreshcheck;
            }else{
                $sector = dropping($_POST);
                $result = querying("SELECT * FROM blackhole WHERE codename_ LIKE '$codename' AND sector_ LIKE '$sector'");
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

    } else {
        header("Location: ../space/");
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
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <style>
        .download td{padding-right: 10px;}
        button, input[type="submit"]{
            width: 100px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php if (isset($_GET["find"])): ?>
        <form action="../result/" method="post" id="direct">
            <input type="hidden" name="codename" value="<?=$row['codename_']?>">
            <input type="hidden" name="sector" value="<?=$row['sector_']?>">
            <input type="hidden" name="action" value="Find!">
            <script>document.getElementById("direct").submit();</script>
            <?php exit; ?>
        </form>
    <?php endif ?>

    <?php if ($_POST["action"] == "Drop!"): ?>
        <p>Success: <span style="color: green; font-weight: bold;"><?= $codename?></span> thrown into a Blackhole in Sector <span style="color: green; font-weight: bold;"><?=$sector?></span></p>
    
    <?php elseif ($_POST["action"] == "Find!"): ?>
        <?php if (!empty($result)): ?>
            <table class="download">
                <tr>
                    <td><?=$result[0]["name_"]?></td>
                    <td><?=$result[0]['size_']?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="codename" value="<?=$codename?>">
                            <input type="hidden" name="sector" value="<?=$sector?>">
                            <input type="hidden" name="name" value="<?=$result[0]['name_']?>">
                            <input type="hidden" name="path" value="<?=$result[0]['savedname_']?>">
                            <input type="submit" name="action" value="Download">
                        </form>
                    </td>
                </tr>
            </table>
        <?php else: ?>
            <p>Invalid codename or sector / Missing file</p>
        <?php endif ?>
    <?php endif ?>
    
    <br>

    <?php if (!empty($result)): ?>
        <p style="display: none;" id="share"><?="http://".$server.'/space/result/?find='.$result[0]['savedname_']?></p>
        <script>
            function share(){
                var input = document.createElement("input");
                input.type = "text";
                var link = document.getElementById("share").innerHTML;
                input.value = link;
                document.body.appendChild(input);
                input.select();
                document.execCommand("copy");
                input.remove();
                alert("link copied sucessfuly");
            }
        </script>
        <button onclick="share()">COPY LINK</button><br><br>
    <?php endif ?>
    <a href="../"><button>BLACKHOLE</button></a>

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