<main>
    <form action="" method="post" id="sign-up-form">
        <h1>Sign Up</h1>
        <div class="field">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" oninput="checkUsernameAvailability()" autocomplete="off" required>
            <span id="username-message"></span>
        </div>
        
        <div class="field">
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required>
            <button type="button" id="toggle-password-visibility" onclick="toggleVisibility('password')">Show</button>
        </div>
        
        <div class="field">
            <label for="confirm-password">Confirm Password:</label><br>
            <input type="password" id="confirm-password" name="confirm-password" required oninput="passwordStatus()">
            <button type="button" id="toggle-confirm-password-visibility" onclick="toggleVisibility('confirm-password')">Show</button><br>
        </div>
        
        <span id="password-match-status"></span><br>
        
        <div>
            <input type="checkbox" id="agreement" name="agreement" required>
            <label for="agreement">I agree to the <a href="">Privacy</a> and <a href="">Terms</a></label><br>
        </div>
        
        <input type="submit" name="submit" value="Sign Up">
    </form>
</main>