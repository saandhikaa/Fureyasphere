<main>
    <form action="" method="post" id="sign-in-form">
        <h1>Sign In</h1>
        <div class="field">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" autocomplete="off" required>
        </div>
        
        <div class="field">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            <button type="button" id="toggle-password-visibility" onclick="toggleVisibility('password')">Show</button>
        </div>
        
        <?php if (isset($data["sign-in-failed"])): ?>
            <span><?= $data["sign-in-failed"] ?></span>
        <?php endif ?>
        
        <br>
        
        <input type="submit" name="submit" id="si-submit" value="Sign In">
        
        <br>
        
        <p>Don't have an account?  <a href="<?= BASEURL . '/' . $data['app'] ?>/signup">Sign Up</a></p>
    </form>
</main>