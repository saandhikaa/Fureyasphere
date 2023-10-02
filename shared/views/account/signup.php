<main id="sign-up">
    <form action="" method="post">
        <h1>Sign Up</h1>
        
        <section class="group-input">
            <label for="username">Username:</label>
            <div class="field">
                <input type="text" id="username" name="username" autocomplete="off" placeholder="give some unique username" required>
            </div>
            <ul>
                <li class="validation username-availability"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Username available</li>
                <li class="validation username-length"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>3-12 characters</li>
                <li class="validation username-format"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Alphabet, number or hyphen</li>
            </ul>
        </section>
        
        <section class="group-input">
            <label for="password">Password:</label>
            <div class="field">
                <input type="password" id="password" name="password" autocomplete="off" placeholder="give a password" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
        </section>
        
        <section class="group-input">
            <label for="confirm-password">Confirm Password:</label>
            <div class="field">
                <input type="password" id="confirm-password" name="confirm-password" autocomplete="off" placeholder="re-type your password" required>
                <button type="button" class="passwordVisibility"><?php readfile(__DIR__ . '/../../assets/images/icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            </div>
            <span class="validation passwords-match"><?php readfile(__DIR__ . '/../../assets/images/icons/check_circle_FILL0_wght400_GRAD0_opsz24.svg') ?>Passwords match</span>
        </section>
        
        <section class="agreement">
            <input type="checkbox" id="agreement" name="agreement" required>
            <label for="agreement">I agree to the <a class="brandeis" href="">Privacy</a> and <a class="brandeis" href="">Terms</a></label>
        </section>
        
        <input type="submit" name="submit" id="su-submit" class="action-button" value="Sign Up" disabled>
    </form>
    
    <section class="go">Already have an account?<a class="brandeis" href="<?= BASEURL . '/' . $data['class'] ?>/signin">Sign In</a></section>
</main>