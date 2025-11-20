<?php
// PAGE TITLE
$title = "Login - 6ixe7ven";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="/static/css/login.css">';

// Start capturing the page content
ob_start();
?>

<main class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Please login to continue</p>

    <div class="login-form">
        <input type="text" placeholder="Username" class="input-field" name="username">
        <input type="password" placeholder="Password" class="input-field" name="password">
        <button class="login-btn">Login</button>
    </div>

    <div class="auth-options">
        <a href="/register.php" class="auth-btn">Register</a>
        <button class="auth-btn">Continue as Guest</button>
    </div>
</main>

<?php
// END capturing content
$content = ob_get_clean();

// Load base layout
include "base.php";
?>
