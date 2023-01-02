<?php
    require "../functions.php";

    $username = "";
    $success = false;

    if (isset($_POST["action"])){
        if ($_POST["action"] == "Register"){
            $time = time();
            $username = stripslashes($_POST["username"]);
            $password = mysqli_real_escape_string($connection, $_POST["password"]);
            $password2 = mysqli_real_escape_string($connection, $_POST["password2"]);

            $result = mysqli_query($connection, "SELECT * FROM spaceship WHERE username_ = '$username'");
            if (!mysqli_fetch_assoc($result)){
                if ($password == $password2){
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_query($connection, "INSERT INTO spaceship (id, username_, password_, level_) VALUES ('$time', '$username', '$password', 1)");
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
    <title>Spaceship: Register</title>
</head>

<body>
    <?php if ($success): ?>
        <script>alert('Success: Acount created successfuly')</script>
        <a href="../spaceship" id="link">next</a>
        <script type="text/javascript"> document.getElementById("link").click(); </script>
    <?php endif ?>

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
                <input type="submit" name="action" value="Register" required>
            </div>
            
            <div class="field">
                <a href="../spaceship">back</a>
            </div>
        </form>
    </div>
    
</body>
</html>