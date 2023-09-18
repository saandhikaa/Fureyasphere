<main id="sign-up">
    <form action="" method="post" id="sign-up-form">
        <h1>Sign Up</h1>
        
        <section class="group-input">
            <label for="username">Username:</label>
            <div class="field">
                <input type="text" id="username" name="username" autocomplete="off" required>
            </div>
            <ul class="validation">
                <li class="username-availability not-pass"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Username available</li>
                <li class="username-length not-pass"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>3-12 characters</li>
                <li class="username-format not-pass"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Alphabet, number & hyphen</li>
            </ul>
        </section>
        
        <section class="group-input">
            <label for="password">Password:</label>
            <div class="field">
                <input type="password" id="password" name="password" autocomplete="off" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
        </section>
        
        <section class="group-input">
            <label for="confirm-password">Confirm Password:</label>
            <div class="field">
                <input type="password" id="confirm-password" name="confirm-password" autocomplete="off" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
            <span class="validation passwords-match not-pass"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Passwords match</span>
        </section>
        
        <section class="agreement">
            <input type="checkbox" id="agreement" name="agreement" required>
            <label for="agreement">I agree to the <a href="">Privacy</a> and <a href="">Terms</a></label><br>
        </section>
        
        <input type="submit" name="submit" id="su-submit" value="Sign Up">
    </form>
    
    <p>Already have an account?  <a href="<?= BASEURL . '/' . $data['app'] ?>/signin">Sign In</a></p>
</main>