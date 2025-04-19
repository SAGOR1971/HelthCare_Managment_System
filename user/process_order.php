<?php
ob_start();
include('header.php');
include('../connect/config.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$delivery_address = $_POST['delivery_address'];
$payment_method = $_POST['payment_method'];
$cart_total = $_POST['cart_total'];

// Start transaction
mysqli_begin_transaction($con);

try {
    // Get cart items
    $cart_query = "SELECT * FROM tblcart WHERE user_id = ?";
    $stmt = $con->prepare($cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    
    if ($cart_result->num_rows === 0) {
        throw new Exception("Your cart is empty");
    }
    
    // Check reward points minimum cart total requirement
    if ($_POST['payment_method'] === 'reward_points') {
        // Check if cart total meets minimum requirement
        if ($cart_total < 500) {
            $_SESSION['error_message'] = "You need to spend at least 500 TaKa to use reward points.";
            header("Location: checkout.php");
            exit();
        }

        // Check if user has enough reward points
        $user_query = "SELECT reward_points FROM tbluser WHERE Id = ?";
        $stmt = $con->prepare($user_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user_result = $stmt->get_result();
        $user_data = $user_result->fetch_assoc();
        $available_reward_points = $user_data['reward_points'];
        $required_points = $cart_total;

        if ($available_reward_points < $required_points) {
            $_SESSION['error_message'] = "You don't have enough reward points for this purchase.";
            header("Location: checkout.php");
            exit();
        }
    }
    
    // Calculate reward points
    $reward_points_used = ($payment_method === 'reward_points') ? $cart_total : 0;
    $reward_points_earned = $cart_total * 0.10; // 10% of total
    
    // Insert order into tblorders with reward points
    $order_query = "INSERT INTO tblorders (user_id, total_amount, payment_method, delivery_address, order_date, payment_status, tracking, reward_points_used, reward_points_earned) 
                    VALUES (?, ?, ?, ?, NOW(), 'Completed', 'Processing', ?, ?)";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param("idssdd", $user_id, $cart_total, $payment_method, $delivery_address, $reward_points_used, $reward_points_earned);
    $stmt->execute();
    $order_id = $con->insert_id;
    
    // If payment method is card and cart total > 100, add reward points
    if ($payment_method === 'card' && $cart_total > 100) {
        // Calculate reward points (10% of cart total)
        $reward_points = $cart_total * 0.10;
        
        // Update user's reward points
        $update_points = "UPDATE tbluser SET reward_points = reward_points + ? WHERE Id = ?";
        $stmt = $con->prepare($update_points);
        $stmt->bind_param("di", $reward_points, $user_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update reward points");
        }
        
        $_SESSION['success_message'] = "Order placed successfully! You earned " . number_format($reward_points, 2) . " reward points!";
    } else {
        $_SESSION['success_message'] = "Order placed successfully!";
    }
    
    // Clear cart
    $clear_cart = "DELETE FROM tblcart WHERE user_id = ?";
    $stmt = $con->prepare($clear_cart);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // If everything is successful, commit the transaction
    mysqli_commit($con);
    
    // Get user details for invoice
    $user_query = "SELECT * FROM tbluser WHERE Id = ?";
    $stmt = $con->prepare($user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    
    // Get order details
    $order_query = "SELECT * FROM tblorders WHERE order_id = ?";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order_data = $order_result->fetch_assoc();
    
    // Store order data in session for invoice generation
    $_SESSION['invoice_data'] = [
        'order_id' => $order_id,
        'user_name' => $user_data['username'],
        'user_email' => $user_data['Email'],
        'user_phone' => $user_data['Number'],
        'delivery_address' => $delivery_address,
        'order_date' => $order_data['order_date'],
        'total_amount' => $cart_total,
        'payment_method' => $payment_method,
        'reward_points_used' => $order_data['reward_points_used'] ?? 0,
        'reward_points_earned' => $reward_points_earned
    ];
    
    // Show success page
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Order Success</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
         <!-- Google Fonts -->
         <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
         <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .success-icon {
                font-size: 5rem;
                color: #28a745;
                margin-bottom: 1rem;
            }
            .invoice-btn {
                background-color: #17a2b8;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
                margin: 10px;
            }
            .invoice-btn:hover {
                background-color: #138496;
                color: white;
            }
            .continue-btn {
                background-color: #28a745;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 5px;
                text-decoration: none;
                display: inline-block;
                margin: 10px;
            }
            .continue-btn:hover {
                background-color: #218838;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container text-center py-5">
            <i class="fas fa-check-circle success-icon"></i>
            <h2 class="mb-4">Order Placed Successfully!</h2>
            <p class="lead mb-4">Thank you for your purchase. Your order ID is #<?php echo $order_id; ?></p>
            
            <div class="card mb-4 mx-auto" style="max-width: 500px;">
                <div class="card-body">
                    <h5 class="card-title">Order Details</h5>
                    <p class="mb-1"><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                    <p class="mb-1"><strong>Date:</strong> <?php echo date('M j, Y g:i A', strtotime($order_data['order_date'])); ?></p>
                    <p class="mb-1"><strong>Total Amount:</strong> <?php echo number_format($cart_total, 2); ?> TaKa</p>
                    <p class="mb-1"><strong>Payment Method:</strong> <?php echo ucfirst($payment_method); ?></p>
                    <?php if ($order_data['reward_points_used'] > 0): ?>
                        <p class="mb-1"><strong>Points Used:</strong> <?php echo number_format($order_data['reward_points_used'], 2); ?></p>
                    <?php endif; ?>
                    <p class="mb-0"><strong>Points Earned:</strong> <?php echo number_format($reward_points_earned, 2); ?></p>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="generate_invoice.php" class="invoice-btn">
                    <i class="fas fa-download me-2"></i>Download Invoice
                </a>
                <a href="index.php" class="continue-btn">
                    <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
                </a>
            </div>
        </div>
        
        <!-- Bootstrap Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
    
} catch (Exception $e) {
    // If there's an error, rollback the transaction
    mysqli_rollback($con);
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: checkout.php");
    exit();
}
?>