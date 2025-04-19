<?php
include '../../connect/config.php';

$id = $_GET['id'];

// Start transaction
mysqli_begin_transaction($con);

try {
    // First get the product name
    $query = "SELECT Pname FROM tblproduct WHERE Id=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if (!$row) {
        throw new Exception("Product not found");
    }
    
    $product_name = $row['Pname'];

    // First delete related price history records
    $delete_history = "DELETE FROM product_price_history WHERE product_id=?";
    $stmt = mysqli_prepare($con, $delete_history);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error deleting price history: " . mysqli_error($con));
    }

    // Then delete the product
    $delete_query = "DELETE FROM tblproduct WHERE Id=?";
    $stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception("Error deleting product: " . mysqli_error($con));
    }

    // If we get here, commit the transaction
    mysqli_commit($con);
    echo "<script>
        alert('Product deleted successfully from all categories!');
        window.location.href='view_products.php';
    </script>";

} catch (Exception $e) {
    // Roll back the transaction on error
    mysqli_rollback($con);
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.location.href='view_products.php';
    </script>";
}
?>
