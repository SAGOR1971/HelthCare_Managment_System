<?php
session_start();
include '../connect/config.php';

if (isset($_POST['delete'])) {
    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];

    // Delete the product from the database
    mysqli_query($con, "DELETE FROM tblcart WHERE user_id = '$user_id' AND product_name = '$product_name'");
    header("Location: view_cart.php");
}
?>