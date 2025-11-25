<?php
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    // On XAMPP
    $BASE_URL = "/E-Commerce-Project";
} else {
    // On Virtualmin (public_html IS the root)
    $BASE_URL = "";
}
?>
