<main id="sign-in">
    <form action="" method="post">
        <h1>Sign In</h1>
        
        <section class="group-input">
            <label for="username">Username:</label>
            <div class="field">
                <input type="text" id="username" name="username" autocomplete="off" placeholder="input your username" required>
            </div>
        </section>
        
        <section class="group-input">
            <label for="password">Password:</label>
            <div class="field">
                <input type="password" id="password" name="password" autocomplete="off" placeholder="input your password" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
        </section>
        
        <span class="sign-in-failed"><?= isset($data["sign-in-failed"]) ? "*" . $data["sign-in-failed"] : "" ?></span>
        
        <input type="submit" name="submit" id="si-submit" class="action-button" value="Sign In">
        
        <section class="go">Don't have an account?<a class="brandeis" href="<?= BASEURL . '/' . $data['app'] ?>/signup">Sign Up</a></section>
    </form>
</main>