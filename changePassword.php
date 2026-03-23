<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "connection.php";

$title = "Change Password - 6ixe7ven";
$extra_css = '<link rel="stylesheet" href="css/changePassword.css">';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $userId = (int)$_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ? LIMIT 1");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $error = "User not found.";
    } elseif (!password_verify($currentPassword, $user['password'])) {
        $error = "Current password is incorrect.";
    } elseif (strlen($newPassword) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ?, force_password_change = 0 WHERE user_id = ?");
        $stmt->bind_param("si", $hashed, $userId);

        if ($stmt->execute()) {
            $_SESSION['force_password_change'] = 0;
            $stmt->close();
            header("Location: dashboard.php?password=changed");
            exit;
        } else {
            $error = "Could not update password. Please try again.";
            $stmt->close();
        }
    }
}

ob_start();
?>

<section class="change-password-page">
    <div class="change-password-card">
        <div class="change-password-header">
            <span class="change-password-tag">Account Security</span>
            <h1>Change Password</h1>
            <p>Update your password to keep your account secure.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="message error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="message success-msg"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form action="changePassword.php" method="POST" class="change-password-form">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Minimum 8 characters" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter new password" required>
            </div>

            <div class="password-hint">
                Your new password should be at least 8 characters long.
            </div>

            <div class="change-password-actions">
                <a href="dashboard.php" class="secondary-btn">Back to Dashboard</a>
                <button type="submit" class="primary-btn">Update Password</button>
            </div>
        </form>
    </div>
</section>

<?php
$content = ob_get_clean();
include "base.php";
?>