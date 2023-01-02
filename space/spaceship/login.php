<?php
    require "../functions.php";

    session_start();

    if (isset($_GET["action"])){
        if ($_GET["action"] == "logout"){
            session_unset();
            session_destroy();
        }
    }

    if (isset($_POST["action"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($connection, "SELECT * FROM spaceship WHERE username_ = '$username'");
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $row['password_'])){
                $_SESSION["login"] = $row['id'];
                header("Location: ../spaceship");
                exit;
            }
        }
        $incorrect = true;
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spaceship: Login</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
</head>

<body>
    <div class="panel">
        <form action="" method="post">
            <h2>LOGIN</h2>

            <div class="field">
                <label for="username"> Username</label><br>
                <input type="text" id="username" name="username" size="20" required>
            </div>

            <div class="field">
                <label for="passwprd"> Password</label><br>
                <input type="password" id="password" name="password" size="20" required>
            </div>

            <p><?=isset($incorrect) ? "*Incorrect" : ""; ?></p>

            <div class="field">
                <input type="submit" name="action" value="LOGIN">
            </div>

            <div class="field">
                <br><a href="../">BLACKHOLE</a>
            </div>
        </form>
    </div>
</body>
</html>