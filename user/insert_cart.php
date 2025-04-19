<?php
session_start();
include '../connect/config.php';

if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']); // Ensure user_id is an integer
    
    // Validate that the user exists in tbluser
    $check_user = mysqli_prepare($con, "SELECT Id FROM tbluser WHERE Id = ?");
    mysqli_stmt_bind_param($check_user, "i", $user_id);
    mysqli_stmt_execute($check_user);
    $user_result = mysqli_stmt_get_result($check_user);
    
    if (mysqli_num_rows($user_result) === 0) {
        echo "<script>
        alert('Invalid user session. Please login again.');
        window.location.href='form/login.php';
        </script>";
        exit();
    }
    
    if (isset($_POST['Pname']) && isset($_POST['Pprice']) && isset($_POST['Pquantity'])) {
        $product_name = $_POST['Pname'];
        $product_price = floatval($_POST['Pprice']);
        $product_quantity = intval($_POST['Pquantity']);
        
        // Check if the product is already in the cart using prepared statement
        $check_query = mysqli_prepare($con, "SELECT * FROM tblcart WHERE user_id = ? AND product_name = ?");
        mysqli_stmt_bind_param($check_query, "is", $user_id, $product_name);
        mysqli_stmt_execute($check_query);
        $result = mysqli_stmt_get_result($check_query);
        
        if (mysqli_num_rows($result) > 0) {
            echo "<script>
            alert('Product Already Added');
            window.location.href='index.php';
            </script>";
        } else {
            // Insert the product into the database using prepared statement
            $insert_query = mysqli_prepare($con, "INSERT INTO tblcart (user_id, product_name, product_price, product_quantity) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_query, "isdi", $user_id, $product_name, $product_price, $product_quantity);
            
            if (mysqli_stmt_execute($insert_query)) {
                // Update the cart count in session immediately using prepared statement
                $cart_count_query = mysqli_prepare($con, "SELECT COUNT(*) AS count FROM tblcart WHERE user_id = ?");
                mysqli_stmt_bind_param($cart_count_query, "i", $user_id);
                mysqli_stmt_execute($cart_count_query);
                $cart_result = mysqli_stmt_get_result($cart_count_query);
                $cart_row = mysqli_fetch_assoc($cart_result);
                $_SESSION['cart_count'] = $cart_row['count'];
                
                header("location:view_cart.php");
                exit();
            } else {
                echo "<script>
                alert('Error adding product to cart. Please try again.');
                window.location.href='index.php';
                </script>";
            }
        }
    } else {
        echo "<script>
        alert('Invalid product information');
        window.location.href='index.php';
        </script>";
    }
} else {
    header("location:form/login.php");
    exit();
}
?>
