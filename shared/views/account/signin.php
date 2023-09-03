<main id="sign-in">
    <form action="" method="post" id="sign-in-form">
        <h1>Sign In</h1>
        <div class="field">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" autocomplete="off" required>
        </div>
        
        <div class="field">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            <button type="button" class="passwordVisibility">Show</button>
        </div>
        
        <span><?= isset($data["sign-in-failed"]) ? $data["sign-in-failed"] : "" ?></span>
        
        <br>
        
        <input type="submit" name="submit" id="si-submit" value="Sign In">
        
        <br>
        
        <p>Don't have an account?  <a href="<?= BASEURL . '/' . $data['app'] ?>/signup">Sign Up</a></p>
    </form>
</main>