<?php
session_start();
include "connection.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id    = (int)$_POST['id'];
    $name  = $_POST['name'] ?? '';
    $price = floatval($_POST['price'] ?? 0);
    $image = $_POST['image'] ?? '';
    $size  = trim($_POST['size'] ?? 'N/A');
    $qty   = max(1, intval($_POST['qty'] ?? 1));

    if ($size === '') {
        $size = 'N/A';
    }

    // Logged-in users: save to database
    if (isset($_SESSION['user_id'])) {
        $userId = (int)$_SESSION['user_id'];

        $stmt = $conn->prepare("
            INSERT INTO basket_items (user_id, product_id, size, quantity)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
        ");
        $stmt->bind_param("iisi", $userId, $id, $size, $qty);

        if ($stmt->execute()) {
            echo "OK";
        } else {
            http_response_code(500);
            echo "ERROR";
        }

        $stmt->close();
        exit;
    }

    // Guests: keep using session
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ((int)$item['id'] === $id && $item['size'] === $size) {
            $item['qty'] += $qty;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'id'    => $id,
            'name'  => $name,
            'price' => $price,
            'image' => $image,
            'size'  => $size,
            'qty'   => $qty
        ];
    }

    echo "OK";
    exit;
}

http_response_code(400);
echo "ERROR";
?>