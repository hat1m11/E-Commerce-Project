<?php
// If the requested file exists, serve it directly
if (file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
    return false;
}

// Otherwise, always serve index.php
include __DIR__ . '/index.php';
