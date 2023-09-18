<main id="sign-in">
    <form action="" method="post" id="sign-in-form">
        <h1>Sign In</h1>
        
        <section class="group-input">
            <label for="username">Username:</label>
            <div class="field">
                <input type="text" id="username" name="username" autocomplete="off" required>
            </div>
        </section>
        
        <section class="group-input">
            <label for="password">Password:</label>
            <div class="field">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
        </section>
        
        <span><?= isset($data["sign-in-failed"]) ? $data["sign-in-failed"] : "" ?></span>
        
        <br>
        
        <input type="submit" name="submit" id="si-submit" value="Sign In">
        
        <br>
        
        <p>Don't have an account?  <a href="<?= BASEURL . '/' . $data['app'] ?>/signup">Sign Up</a></p>
    </form>
</main>