<?php
session_start(); // session active
session_unset();
session_destroy(); // log out
header("Location: login.php");
exit;