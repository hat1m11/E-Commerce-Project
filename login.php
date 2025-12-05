<?php
// PAGE TITLE
$title = "Login - 6ixe7ven";

// PAGE-SPECIFIC CSS
$extra_css = '<link rel="stylesheet" href="static/css/login.css">';

// Start capturing the page content
ob_start();
?>

<main class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Please login to continue</p>

    <!-- REAL FORM -->
    <form action="controllers/admin/adminAuthController.php" method="POST" class="login-form">

        <input type="text" 
               placeholder="Username" 
               class="input-field" 
               name="username" 
               required>

        <input type="password" 
               placeholder="Password" 
               class="input-field" 
               name="password" 
               required>

        <button class="login-btn" type="submit">Login</button>
    </form>

    <div class="auth-options">
        <a href="register.php" class="auth-btn">Register</a>
        <button class="auth-btn">Continue as Guest</button>
    </div>
</main>

<?php
$content = ob_get_clean(); // get content
include "base.php"; // load layout
?>
