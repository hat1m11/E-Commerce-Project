<?php
session_start();

// Hardcoded admin credentials for now
$admin_user = "admin";
$admin_pass = "admin123";

// Get login form values
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Check if admin
if ($username === $admin_user && $password === $admin_pass) {

    // Set admin session
    $_SESSION['admin'] = true;

    // Redirect to admin dashboard
    header("Location: ../../admin/dashboard.php");
    exit;

} else {
    // Redirect back with error
    header("Location: ../../login.php?error=1");
    exit;
}
