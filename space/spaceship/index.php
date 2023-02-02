<?php
    require "../functions.php";
    date_default_timezone_set("Asia/Jakarta");

    purging("../");

    session_start();
    if (!isset($_SESSION["login"])){
        header("Location: login.php");
    }
    $userid = $_SESSION["login"];
    $owner = querying("SELECT username_ FROM spaceship WHERE id = '$userid'")[0]["username_"];
    
    $logline = querying("SELECT * FROM logging");
    $lasting = querying("SELECT * FROM blackhole");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$owner?></title>
    <script src="../functions.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

</head>

<body>
    <a href="../setup/"><input type="submit" value="SETUP"></a><br>
    <a href="register.php"><input type="submit" value="REGISTER"></a><br>
    <a href="login.php?action=logout"><input type="submit" value="LOGOUT"></a><br>
    <a href="../"><input type="submit" value="BLACKHOLE"></a><br><hr>
    
    <div class="list">
        <?php if (!empty($lasting)): ?>
            <h2>Lasting</h2>
            <table cellspacing="0">
                <tr style="background-color: #067D68;">
                    <th>No.</th>
                    <th>Owner</th>
                    <th>Codename</th>
                    <th>Sector</th>
                    <th>File name</th>
                    <th>Size</th>
                    <th>Listed</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
                <?php for ($i = 0; $i < count($lasting); $i++): ?>
                    <tr style="border-bottom: 1px solid #067D68;">
                        <td><?=$i+1?></td>
                        <td><?=$lasting[$i]['owner_']?></td>
                        <td><?=$lasting[$i]['codename_']?></td>
                        <td><?=$lasting[$i]['sector_']?></td>
                        <td><?=$lasting[$i]['name_']?></td>
                        <td><?=$lasting[$i]['size_']?></td>
                        <td><?= date("d/m/Y -- H:i:s", $lasting[$i]['id'])." WIB"?></td>
                        <td><?=$lasting[$i]['hours_'] . " hours"?></td>
                        <td>
                            <?php $shareid = "spaceshare".$i ?>
                            <p style="display: none;" id="<?=$shareid?>"><?="http://".$server.'/space/result/?find='.$lasting[$i]['savedname_']?></p>
                            <button style="cursor: pointer; margin: 2px; width: 80px;" onclick="share('<?=$shareid?>')">LINK</button>
                            <a href="<?="http://".$server.'/space/result/?find='.$lasting[$i]['savedname_']?>" target="_blank"><button style="cursor: pointer; margin: 2px; width: 80px;">OPEN</button></a>
                        </td>
                    </tr>
                <?php endfor ?>
            </table><br><br>
        <?php endif ?>
    </div>
    
    <div class="list">
        <h2>Logging</h2>
        <table cellspacing="0">
            <tr style="background-color: #067D68;">
                <th>No.</th>
                <th>Owner</th>
                <th>Codename</th>
                <th>File name</th>
                <th>Size</th>
                <th>Listed</th>
            </tr>
            <?php for ($i = count($logline) - 1; $i >= 0; $i--): ?>
                <tr style="border-bottom: 1px solid #067D68;">
                    <td><?=count($logline) - $i?></td>
                    <td><?=$logline[$i]['owner_']?></td>
                    <td><?=$logline[$i]['codename_']?></td>
                    <td><?=$logline[$i]['name_']?></td>
                    <td><?=$logline[$i]['size_']?></td>
                    <td><?= date("d/m/Y -- H:i:s", $logline[$i]['id'])." WIB"?></td>
                </tr>
            <?php endfor ?>
        </table>
    </div>

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