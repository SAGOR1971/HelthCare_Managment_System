<?php
include '../../connect/config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already started
}
if (!isset($_SESSION['admin'])) {
    header("location:../form/login.php");
    exit();
}
header("location:add_product.php");
exit();
?>

