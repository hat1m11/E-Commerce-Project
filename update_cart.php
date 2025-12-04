<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['index']) && isset($_POST['qty'])) {
    $index = intval($_POST['index']);
    $qty = max(1, intval($_POST['qty']));

    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['qty'] = $qty;
    }
}
?>
