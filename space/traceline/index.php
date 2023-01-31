<?php
    require "../functions.php";
    date_default_timezone_set("Asia/Jakarta");

    $message = querying("SELECT * FROM traceline");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COMMENT LIST</title>
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Source Sans Pro', sans-serif;">
    <h2>All comment</h2>
    <a href="../">back</a>
    <div class="open">
        <table >
            <?php for ($row = 0; $row < count($message); $row++): ?>
                <tr>
                    <td style="text-align: left; width: 20px;"><?=$row+1?></td>
                    <td><p style="font-weight: bold;"><?=$message[$row]["penname_"]?><span style="font-weight: normal; color:dimgray"> at <?=date("M j - H:i", $message[$row]["id"])?></span></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?=$message[$row]["message_"]?></td>
                </tr>
                <tr style="height: 20px;"><td></td><td></td></tr>
            <?php endfor ?>
        </table>
    </div>

    <div class="leave">
        <h2>Leave a comment</h2>
        <form action="../processing.php" method="post">
            <table>
                <tr>
                    <td>Pen name</td>
                    <td><input type="text" name="penname" size="30" required></td>
                </tr>
                <tr>
                    <td style="vertical-align: top;">Comment</td>
                    <td><textarea style="resize: vertical;" name="message" cols="30" rows="10" required></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="action" value="Send comment!"></td>
                </tr>
            </table>
        </form>
    </div>
    
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