<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit;
}


if (!isset($_SESSION['is_active']) || (int)$_SESSION['is_active'] !== 1) {
    session_destroy();
    header("Location: /login.php?error=account_disabled");
    exit;
}

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo "403 Forbidden - Admin access only";
    exit;
}
