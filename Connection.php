<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username   = "cs2team67";
$password   = "16M5siQjzaAyL1Xppt302lCHI";
$dbname     = "cs2team67_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Do NOT echo anything here – it breaks PAGE HTML
?>
