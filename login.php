<?php 
session_start(); // start session
include "connection.php"; // db link

$title = "Login - 6ixe7ven"; // page title

$extra_css = '<link rel="stylesheet" href="css/login.css">'; // page css

// form check
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? ''); // username input
    $password = trim($_POST['password'] ?? ''); // password input

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields."; // empty fields
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); // lookup user
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $error = "Username not found."; // no user
        } elseif ($password !== $user['password']) {
            $error = "Incorrect password."; // wrong pass
        } else {
            $_SESSION['user_id'] = $user['user_id']; // save session
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];

            header("Location: dashboard.php"); // go dashboard
            exit;
        }
    }
}

ob_start(); // buffer start
?>

<main class="hero">
    <h1>Welcome to 6ixe7ven</h1>
    <p>Please login to continue</p>

    <?php if (isset($error)): ?>
        <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST" class="login-form">
        <input type="text" placeholder="Username" class="input-field" name="username" required>
        <input type="password" placeholder="Password" class="input-field" name="password" required>
        <button class="login-btn" type="submit">Login</button>
    </form>

    <div class="auth-options">
        <a href="register.php" class="auth-btn">Register</a>
        <button class="auth-btn" onclick="window.location.href='index.php';">Continue as Guest</button>
    </div>
</main>

<?php
$content = ob_get_clean(); // get content
include "base.php"; // load layout
?>
