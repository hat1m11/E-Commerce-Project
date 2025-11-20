<?php
$title = "Sign Up - 6ixe7ven";

// FIXED CSS PATH (remove leading slash)
$extra_css = '<link rel="stylesheet" href="static/css/register.css">';

// JS path was already correct
$extra_js  = '<script src="static/js/register.js"></script>';

ob_start();
?>

<main class="register-wrapper">

    <h2 class="register-title">Sign Up</h2>

    <div class="register-container">
        <section class="form-section">

            <form>

                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter your full name">
                <small class="error-msg" id="fullname-error"></small>

                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter your address">
                <small class="error-msg" id="address-error"></small>

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
                <small class="error-msg" id="phone-error"></small>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address">
                <small class="error-msg" id="email-error"></small>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password">
                <small class="error-msg" id="password-error"></small>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password">
                <small class="error-msg" id="confirm-password-error"></small>

                <button type="submit" class="signup-button">Sign Up</button>

                <p class="login-text">
                    Already have an account? <a href="login.php">Log in here</a>.
                </p>

            </form>

        </section>
    </div>

</main>

<?php
$content = ob_get_clean();
include "base.php";
?>
