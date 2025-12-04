<?php
session_start();

// Make sure the cart array exists
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Handle add-to-cart POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'] ?? '';
    $price = floatval($_POST['price'] ?? 0);
    $image = $_POST['image'] ?? '';

    $found = false;

    // Check if item is already in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $id) {
            $item['qty']++;  // increase quantity
            $found = true;
            break;
        }
    }
    unset($item); // remove reference

    // If not found, add new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'qty' => 1
        ];
    }

    echo "OK"; // success
    exit;
}

// Invalid request fallback
http_response_code(400);
echo "ERROR";
?>
