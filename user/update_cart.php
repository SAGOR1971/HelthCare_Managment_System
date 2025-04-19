<?php
session_start();
include '../connect/config.php';

if (isset($_POST['update'])) {
    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $new_quantity = $_POST['quantity'];

    // Update the quantity in the database
    mysqli_query($con, "UPDATE tblcart SET product_quantity = '$new_quantity' WHERE user_id = '$user_id' AND product_name = '$product_name'");
    header("Location: view_cart.php");
}
?>