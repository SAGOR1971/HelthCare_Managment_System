<?php
ob_start();
include('../connect/config.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle invoice download request
if (isset($_POST['download_invoice'])) {
    $order_id = $_POST['order_id'];
    
    // Get order details
    $order_query = "SELECT o.*, u.username, u.Email, u.Number 
                    FROM tblorders o 
                    JOIN tbluser u ON o.user_id = u.Id 
                    WHERE o.order_id = ? AND o.user_id = ?";
    $stmt = $con->prepare($order_query);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $order_result = $stmt->get_result();
    $order_data = $order_result->fetch_assoc();
    
    if ($order_data) {
        // Store order data in session for invoice generation
        $_SESSION['invoice_data'] = [
            'order_id' => $order_data['order_id'],
            'user_name' => $order_data['username'],
            'user_email' => $order_data['Email'],
            'user_phone' => $order_data['Number'],
            'delivery_address' => $order_data['delivery_address'],
            'order_date' => $order_data['order_date'],
            'total_amount' => $order_data['total_amount'],
            'payment_method' => $order_data['payment_method'],
            'reward_points_used' => $order_data['reward_points_used'] ?? 0,
            'reward_points_earned' => $order_data['reward_points_earned'] ?? 0
        ];
        
        // Redirect to generate invoice
        header("Location: generate_invoice.php");
        exit();
    }
}

// Fetch all orders for the user
$query = "SELECT * FROM tblorders WHERE user_id = ? ORDER BY order_date DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Status</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
        }
        .status-processing { background-color: #ffd700; color: #000; }
        .status-transit { background-color: #87ceeb; color: #000; }
        .status-delivered { background-color: #90ee90; color: #000; }
        .order-details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .invoice-btn {
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        .invoice-btn:hover {
            background-color: #138496;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">My Orders</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order-card">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Order #<?php echo $order['order_id']; ?></h4>
                            <p><strong>Order Date:</strong> <?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></p>
                            <p><strong>Total Amount:</strong> <?php echo number_format($order['total_amount'], 2); ?> TaKa</p>
                            <p><strong>Payment Method:</strong> <?php echo ucfirst($order['payment_method']); ?></p>
                            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>Status: 
                                <span class="status-badge status-<?php echo strtolower($order['tracking']); ?>">
                                    <?php echo ucfirst($order['tracking']); ?>
                                </span>
                            </h5>
                            <?php if ($order['reward_points_used'] > 0): ?>
                                <p><strong>Reward Points Used:</strong> <?php echo number_format($order['reward_points_used'], 2); ?></p>
                            <?php endif; ?>
                            <?php if ($order['reward_points_earned'] > 0): ?>
                                <p><strong>Reward Points Earned:</strong> <?php echo number_format($order['reward_points_earned'], 2); ?></p>
                            <?php endif; ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                <button type="submit" name="download_invoice" class="invoice-btn">
                                    <i class="fas fa-download me-2"></i>Download Invoice
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">
                You don't have any orders yet. 
                <a href="index.php" class="alert-link">Start shopping now</a>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
<?php ob_end_flush(); ?> 