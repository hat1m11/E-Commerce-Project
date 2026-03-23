<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    $qty = max(1, (int)$_POST['qty']);

    if (isset($_SESSION['user_id']) && isset($_POST['basket_item_id'])) {
        $userId = (int)$_SESSION['user_id'];
        $basketItemId = (int)$_POST['basket_item_id'];

        $stmt = $conn->prepare("
            UPDATE basket_items
            SET quantity = ?
            WHERE basket_item_id = ? AND user_id = ?
        ");
        $stmt->bind_param("iii", $qty, $basketItemId, $userId);

        if ($stmt->execute()) {
            echo "OK";
        } else {
            http_response_code(500);
            echo "ERROR";
        }

        $stmt->close();
        exit;
    }

    if (isset($_POST['index'])) {
        $index = (int)$_POST['index'];

        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['qty'] = $qty;
            echo "OK";
            exit;
        }
    }
}

http_response_code(400);
echo "ERROR";
?>