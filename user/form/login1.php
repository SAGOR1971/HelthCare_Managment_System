<?php
session_start();
include '../../connect/config.php';
$Name = $_POST['name'];
$Password = $_POST['password'];

$result = mysqli_query($con, "SELECT * FROM tbluser WHERE username = '$Name' OR Email = '$Name' AND Password = '$Password'");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $Name;
    $_SESSION['user_id'] = $row['Id']; // Store user_id in the session

    // Load cart data from the database into the session
    $user_id = $_SESSION['user_id'];
    $cart_query = mysqli_query($con, "SELECT * FROM tblcart WHERE user_id = '$user_id'");
    $_SESSION['cart'] = array();
    while ($cart_row = mysqli_fetch_assoc($cart_query)) {
        $_SESSION['cart'][] = array(
            'productName' => $cart_row['product_name'],
            'productPrice' => $cart_row['product_price'],
            'productQuantity' => $cart_row['product_quantity']
        );
    }

    echo "
    <script>
    alert('Successful Login');
    window.location.href = '../about.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Incorrect Email or Password');
    window.location.href = 'login.php';
    </script>
    ";
}
?>