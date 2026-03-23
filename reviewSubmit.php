<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "connection.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$userId = (int)$_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: products.php");
    exit;
}

$productId = (int)($_POST["product_id"] ?? 0);
$rating    = (int)($_POST["rating"] ?? 0);
$comment   = trim($_POST["comment"] ?? "");

$redirect = trim($_POST["redirect"] ?? "");
if ($redirect === "") {
    $redirect = "products.php";
}


if (preg_match("/^https?:\/\//i", $redirect)) {
    $redirect = "products.php";
}


if ($productId <= 0 || $rating < 1 || $rating > 5) {
    header("Location: {$redirect}?review=error");
    exit;
}

if (strlen($comment) > 2000) {
    $comment = substr($comment, 0, 2000);
}


$stmt = $conn->prepare("SELECT product_id FROM products WHERE product_id = ? LIMIT 1");
$stmt->bind_param("i", $productId);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$exists) {
    header("Location: {$redirect}?review=notfound");
    exit;
}


$stmt = $conn->prepare("
    INSERT INTO reviews (product_id, user_id, rating, comment, status)
    VALUES (?, ?, ?, ?, 'approved')
    ON DUPLICATE KEY UPDATE rating = VALUES(rating), comment = VALUES(comment), status = 'approved'
");
$stmt->bind_param("iiis", $productId, $userId, $rating, $comment);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: {$redirect}?review=ok");
    exit;
}

$stmt->close();
header("Location: {$redirect}?review=error");
exit;
