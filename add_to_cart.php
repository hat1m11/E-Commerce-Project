<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['id'])) {
    $_SESSION['cart'][] = [
        "id" => $_POST["id"],
        "name" => $_POST["name"],
        "price" => $_POST["price"],
        "image" => $_POST["image"]
    ];
}

echo "OK";
?>
