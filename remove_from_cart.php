<?php
session_start();

// Only run when a valid POST request is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['index'])) {
    $index = intval($_POST['index']);

    // Remove item if it exists
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // tidy up indexes
    }

    echo "OK";
    exit;
}

// Bad request
http_response_code(400);
echo "ERROR";
exit;
?>
