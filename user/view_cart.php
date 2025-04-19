<?php
session_start();
include '../connect/config.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user_id is not set
    header("location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Delete All
if(isset($_POST['delete_all'])) {
    $delete_query = "DELETE FROM tblcart WHERE user_id = '$user_id'";
    if(mysqli_query($con, $delete_query)) {
        echo "<script>alert('All items have been removed from your cart!');
        window.location.href='view_cart.php';</script>";
    }
}

// Handle Update All
if(isset($_POST['update_all'])) {
    $quantities = $_POST['quantities'];
    foreach($quantities as $product_name => $quantity) {
        if($quantity > 0) {
            $update_query = "UPDATE tblcart SET product_quantity = '$quantity' 
                           WHERE user_id = '$user_id' AND product_name = '$product_name'";
            mysqli_query($con, $update_query);
        }
    }
    echo "<script>alert('All quantities have been updated!');
    window.location.href='view_cart.php';</script>";
}

$cart_items = mysqli_query($con, "SELECT * FROM tblcart WHERE user_id = '$user_id'");
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center bg-light mb-5 rounded">
                <h1 class="text-warning">My Cart</h1>
            </div>
        </div>
        <?php
        $cart_count = mysqli_num_rows($cart_items);
        if ($cart_count > 0) {
        ?>
            <div class="row">
                <div class="col-lg-12 text-center mb-3">
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete all items from your cart?');">
                        <button type="submit" name="delete_all" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete All
                        </button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-around">
                <div class="col-lg-12">
                    <form method="POST">
                        <table class="table table-bordered text-center">
                            <thead class="bg-danger text-white fs-5">
                                <th>Index Number</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Quantity</th>
                                <th>Total Price</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($cart_items)) {
                                    $total_price = $row['product_price'] * $row['product_quantity'];
                                    $total += $total_price;
                                    echo "
                                    <tr>
                                        <td>$no</td>
                                        <td>{$row['product_name']}</td>
                                        <td>{$row['product_price']}</td>
                                        <td>
                                            <input type='number' name='quantities[{$row['product_name']}]' value='{$row['product_quantity']}' min='1' class='form-control w-75 mx-auto' required>
                                        </td>
                                        <td>$total_price</td>
                                        <td>
                                            <button type='button' class='btn btn-danger' onclick='deleteItem(\"{$row['product_name']}\")'>Delete</button>
                                        </td>
                                    </tr>
                                    ";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h2 class="text-warning">Total Price: <?php echo number_format($total, 2); ?> TaKa</h2>
                            <div class="d-flex gap-2">
                                <button type="submit" name="update_all" class="btn btn-warning">
                                    <i class="fas fa-sync"></i> Update All Quantities
                                </button>
                                <div class="checkout-btn">
                                    <a href="checkout.php" class="btn btn-primary <?php echo ($total > 0) ? '' : 'disabled'; ?>">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Hidden form for delete operations -->
                    <form id="deleteForm" action="delete_cart.php" method="POST" style="display: none;">
                        <input type="hidden" name="product_name" id="deleteProductName">
                        <input type="hidden" name="delete" value="1">
                    </form>

                    <script>
                        function deleteItem(productName) {
                            if (confirm('Are you sure you want to remove this item from your cart?')) {
                                document.getElementById('deleteProductName').value = productName;
                                document.getElementById('deleteForm').submit();
                            }
                        }
                    </script>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <h3>Your cart is empty</h3>
                        <p>Add some products to your cart to see them here.</p>
                        <a href="index.php" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-bag"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <?php
    if (isset($_POST['checkout']) && $total > 0) {
        // Calculate reward points if total is >= 100
        if ($total >= 100) {
            $reward_points = $total * 0.10; // 10% of total
            
            // Update user's reward points
            $user_id = $_SESSION['user_id'];
            mysqli_query($con, "UPDATE tbluser SET reward_points = reward_points + $reward_points WHERE Id = '$user_id'");
        }

        // Clear the cart
        mysqli_query($con, "DELETE FROM tblcart WHERE user_id = '$user_id'");

        // Redirect to a thank you page or show success message
        echo "<script>
            alert('Thank you for your purchase! Your order has been processed.');
            window.location.href = 'index.php';
        </script>";
    }
    ?>
    <?php include 'footer.php'; ?>
</body>
</html>