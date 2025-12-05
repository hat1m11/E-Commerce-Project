<?php
session_start();
include "connection.php";

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: index.php"); // no access
    exit;
}

$userId = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

$total = array_reduce($cart, fn($carry,$i)=>$carry+$i['price']*$i['qty'],0); // cart total

$conn->begin_transaction(); // start transaction

try {
    $stmtOrder = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmtOrder->bind_param("id", $userId, $total);
    $stmtOrder->execute();
    $orderId = $stmtOrder->insert_id;

    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $stmtItem->bind_param("iiid", $orderId, $item['id'], $item['qty'], $item['price']);
        $stmtItem->execute();
    }

    $conn->commit(); // done
    unset($_SESSION['cart']);
    header("Location: thankyou.php"); // go to thank you page
    exit;

} catch(Exception $e) {
    $conn->rollback(); // undo on error
    echo "Error processing order: ".$e->getMessage();
}
?>
