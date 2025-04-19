<?php
ob_start();
include('../connect/config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: form/login.php");
    exit();
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id']) && isset($_POST['tracking'])) {
    $order_id = $_POST['order_id'];
    $tracking = $_POST['tracking'];
    
    $update_query = "UPDATE tblorders SET tracking = ? WHERE order_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("si", $tracking, $order_id);
    $stmt->execute();
    
    header("Location: manage_orders.php");
    exit();
}

// Fetch all orders with user details
$query = "SELECT o.*, u.username, u.Email 
          FROM tblorders o 
          JOIN tbluser u ON o.user_id = u.Id 
          ORDER BY o.order_date DESC";
$result = mysqli_query($con, $query);

// Get statistics
$total_orders = mysqli_num_rows($result);
$processing_orders = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblorders WHERE tracking = 'Processing'"));
$transit_orders = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblorders WHERE tracking = 'Transit'"));
$delivered_orders = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblorders WHERE tracking = 'Delivered'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .stats-card {
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .order-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .order-card:hover {
            transform: translateY(-5px);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-processing { 
            background-color: var(--warning-color);
            color: #000;
        }

        .status-transit { 
            background-color: var(--info-color);
            color: #fff;
        }

        .status-delivered { 
            background-color: var(--success-color);
            color: #fff;
        }

        .order-details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e3e6f0;
        }

        .form-select {
            border-radius: 20px;
            padding: 8px 15px;
            border: 1px solid #d1d3e2;
        }

        .btn-update {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .stats-icon {
            font-size: 2rem;
            opacity: 0.3;
        }

        .order-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .customer-info {
            background-color: var(--light-color);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .order-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .reward-points {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-dark mb-4">Order Management Dashboard</h2>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card border-left-primary h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_orders; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart stats-icon text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card border-left-warning h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Processing Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $processing_orders; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock stats-icon text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card border-left-info h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">In Transit</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $transit_orders; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-truck stats-icon text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card border-left-success h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Delivered Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $delivered_orders; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle stats-icon text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
                    </div>
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                                <div class="order-card bg-white p-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="customer-info">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-user order-icon"></i>
                                                    Order #<?php echo $order['order_id']; ?>
                                                </h5>
                                                <p class="mb-1"><strong>Customer:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
                                                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($order['Email']); ?></p>
                                                <p class="mb-1"><strong>Order Date:</strong> <?php echo date('M j, Y g:i A', strtotime($order['order_date'])); ?></p>
                                                <p class="mb-1"><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['delivery_address']); ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-end">
                                                <h5 class="order-amount mb-3">
                                                    <?php echo number_format($order['total_amount'], 2); ?> TaKa
                                                </h5>
                                                <p class="mb-3">
                                                    <span class="status-badge status-<?php echo strtolower($order['tracking']); ?>">
                                                        <?php echo ucfirst($order['tracking']); ?>
                                                    </span>
                                                </p>
                                                <form method="POST" class="mt-3">
                                                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                    <div class="mb-3">
                                                        <select name="tracking" class="form-select">
                                                            <option value="Processing" <?php echo $order['tracking'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                                            <option value="Transit" <?php echo $order['tracking'] == 'Transit' ? 'selected' : ''; ?>>Transit</option>
                                                            <option value="Delivered" <?php echo $order['tracking'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-update">
                                                        <i class="fas fa-sync-alt me-2"></i>Update Status
                                                    </button>
                                                </form>
                                                <?php if ($order['reward_points_used'] > 0 || $order['reward_points_earned'] > 0): ?>
                                                    <div class="reward-points mt-3">
                                                        <?php if ($order['reward_points_used'] > 0): ?>
                                                            <p class="mb-1"><strong>Points Used:</strong> <?php echo number_format($order['reward_points_used'], 2); ?></p>
                                                        <?php endif; ?>
                                                        <?php if ($order['reward_points_earned'] > 0): ?>
                                                            <p class="mb-0"><strong>Points Earned:</strong> <?php echo number_format($order['reward_points_earned'], 2); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No Orders Found</h4>
                                <p class="text-muted">There are no orders to manage at the moment.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
<?php ob_end_flush(); ?> 