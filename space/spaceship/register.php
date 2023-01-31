<?php
    require "../functions.php";

    $username = "";
    $success = false;

    session_start();
    if (!isset($_SESSION["login"])){
        header("Location: login.php");
    }

    $userid = $_SESSION["login"];
    $users = querying("SELECT id FROM spaceship WHERE level_ = 1");
    for ($i = 0; $i < count($users); $i++){
        $level1[$i] = $users[$i]["id"];
    }
    if (!in_array($userid, $level1)){
        header("Location: ../spaceship/");
    }

    if (isset($_POST["action"])){
        if ($_POST["action"] == "Register"){
            $time = time();
            $username = stripslashes($_POST["username"]);
            $password = mysqli_real_escape_string($connection, $_POST["password"]);
            $password2 = mysqli_real_escape_string($connection, $_POST["password2"]);
            $level = $_POST["level"];

            $result = mysqli_query($connection, "SELECT * FROM spaceship WHERE username_ = '$username'");
            if (!mysqli_fetch_assoc($result)){
                if ($password == $password2){
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_query($connection, "INSERT INTO spaceship (id, username_, password_, level_) VALUES ('$time', '$username', '$password', '$level')");
                    if (mysqli_affected_rows($connection)){
                        $success = true;
                        notification(array("notification"=>"Account created.\n\n".$username."\n\nhttps://saandhikaa.github.io/rose\n"));
                    }
                }else{
                    echo "<script>alert('Password is'nt match')</script>";
                }
            }else{
                $username = "";
                echo "<script>alert('Username alredy use, try another one!')</script>";
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
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <title>REGISTER</title>
</head>

<body>
    <?php if ($success): ?>
        <script>alert('Success: Acount created successfuly')</script>
        <a href="../spaceship/" id="link">next</a>
    
    <?php else: ?>
        <div class="panel">
            <form action="" method="post">
                <h2>REGISTER</h2>
                <div class="field">
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="username" value="<?=$username ?>" required>
                </div>

                <div class="field">
                    <label for="password">Password</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                
                <div class="field">
                    <label for="password2">Confirm password</label><br>
                    <input type="password" name="password2" id="password2" required>
                </div>

                <div class="field">
                    <label for="level">Level</label><br>
                    <input type="number" name="level" id="level" min="1" max="9" required>
                </div>

                <div class="field">
                    <input type="submit" name="action" value="Register" required>
                </div>
                
                <div class="field">
                    <br><a href="../">BLACKHOLE</a>
                </div>
            </form>
        </div>
    <?php endif ?>
    
</body>
</html>