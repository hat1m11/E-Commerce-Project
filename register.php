<?php
session_start();
include "connection.php"; // DB connection

$title = "Sign Up - 6ixe7ven";

// Page styling/scripts
$extra_css = '<link rel="stylesheet" href="static/css/register.css">';
$extra_js  = '<script src="static/js/register.js"></script>';

$error = '';
$success = '';

// Form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get inputs
    $fullname = trim($_POST['fullname'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm-password'] ?? '');

    // Basic checks
    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($confirm)) {
        $error = "Please fill in all required fields.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {

        // Check if taken
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {

            // Save new user
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO users (full_name, address, phone, email, username, password, created_at)
                VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->bind_param("ssssss", $fullname, $address, $phone, $email, $username, $password_hash);

            if ($stmt->execute()) {
                $success = "Account created successfully! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Database error: " . $stmt->error;
            }
        }
    }
}

ob_start(); // Capture page
?>

<main class="register-wrapper">
    <h2 class="register-title">Sign Up</h2>

    <?php if ($error): ?>
        <p class="error-msg"><?= $error ?></p>
    <?php elseif ($success): ?>
        <p class="success-msg"><?= $success ?></p>
    <?php endif; ?>

    <div class="register-container">
        <section class="form-section">

            <form action="register.php" method="POST" class="register-form">

                <input type="text" name="fullname" placeholder="Full Name" required>
                <input type="text" name="address" placeholder="Address">
                <input type="text" name="phone" placeholder="Phone">
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm-password" placeholder="Confirm Password" required>

                <button type="submit" class="signup-button">Sign Up</button>
            </form>
        </section>
    </div>

    <p class="login-text">
        Already have an account? <a href="login.php">Log in here</a>.
    </p>
</main>

<?php
$content = ob_get_clean(); // Final page output
include "base.php";
?>
