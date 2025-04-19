<?php
ob_start(); // Start output buffering
include('../connect/config.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_total = 0;

// Get cart total from session or database
$cart_query = mysqli_query($con, "SELECT SUM(product_price * product_quantity) as total FROM tblcart WHERE user_id = '$user_id'");
$cart_result = mysqli_fetch_assoc($cart_query);
$cart_total = $cart_result['total'] ?? 0;

// Get user's current reward points
$query = "SELECT reward_points FROM tbluser WHERE Id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$available_reward_points = $user_data['reward_points'];

// Calculate required points (1:1 ratio)
$required_points = $cart_total;

// Calculate potential reward points (10% of cart total, only if cart total > 100)
$potential_reward_points = $cart_total > 100 ? ($cart_total * 0.10) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
        .payment-section { display: none; }
        .active { display: block; }
        .error { color: red; }
        .success { color: green; }
        .info { color: #0066cc; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>
        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <form id="checkoutForm" method="POST" action="process_order.php">
            <div class="form-group">
                <label>Delivery Address:</label>
                <textarea name="delivery_address" required class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Select Payment Method:</label>
                <select name="payment_method" id="paymentMethod" required class="form-control">
                    <option value="">Select Payment Method</option>
                    <option value="reward_points">Reward Points (Available: <?php echo number_format($available_reward_points, 2); ?>)</option>
                    <option value="card">Card Payment</option>
                </select>
            </div>

            <div id="rewardPointsSection" class="payment-section">
                <p>Cart Total: <?php echo number_format($cart_total, 2); ?> TaKa</p>
                <p>Required Points: <?php echo number_format($required_points, 2); ?></p>
                <p>Your Points: <?php echo number_format($available_reward_points, 2); ?></p>
                <?php if ($cart_total <= 300): ?>
                    <p class="error">You need to spend at least 300 TaKa to use reward points.</p>
                <?php elseif ($available_reward_points < $required_points): ?>
                    <p class="error">You don't have enough reward points for this purchase.</p>
                <?php endif; ?>
            </div>

            <div id="cardPaymentSection" class="payment-section">
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" name="card_number" class="form-control" pattern="[0-9]{8}" maxlength="8" placeholder="Enter 8 digit card number">
                </div>
                <div class="form-group">
                    <label>Expiry Date:</label>
                    <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY">
                </div>
                <div class="form-group">
                    <label>CVV:</label>
                    <input type="text" name="cvv" class="form-control" maxlength="4" placeholder="Enter CVV">
                </div>
                <?php if ($cart_total > 100): ?>
                    <p class="info">You will earn <?php echo number_format($potential_reward_points, 2); ?> reward points with this purchase!</p>
                <?php else: ?>
                    <p class="info">Spend more than 100 TaKa to earn reward points! You need <?php echo number_format(100 - $cart_total, 2); ?> TaKa more.</p>
                <?php endif; ?>
            </div>

            <input type="hidden" name="cart_total" value="<?php echo $cart_total; ?>">
            <input type="hidden" name="potential_reward_points" value="<?php echo $potential_reward_points; ?>">
            <br></br>
            <button type="submit" id="payButton" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const rewardPointsSection = document.getElementById('rewardPointsSection');
            const cardPaymentSection = document.getElementById('cardPaymentSection');
            const payButton = document.getElementById('payButton');
            const availablePoints = <?php echo $available_reward_points; ?>;
            const requiredPoints = <?php echo $required_points; ?>;
            const cartTotal = <?php echo $cart_total; ?>;
            
            rewardPointsSection.classList.remove('active');
            cardPaymentSection.classList.remove('active');
            payButton.disabled = false;
            
            if(this.value === 'reward_points') {
                rewardPointsSection.classList.add('active');
                if(availablePoints < requiredPoints || cartTotal <= 300) {
                    payButton.disabled = true;
                }
            } else if(this.value === 'card') {
                cardPaymentSection.classList.add('active');
            }
        });

        // Add validation for card payment fields
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            const paymentMethod = document.getElementById('paymentMethod').value;
            
            if(paymentMethod === 'card') {
                const cardNumber = document.querySelector('input[name="card_number"]').value;
                const expiryDate = document.querySelector('input[name="expiry_date"]').value;
                const cvv = document.querySelector('input[name="cvv"]').value;
                
                // Validate card number (8 digits)
                if(!/^\d{8}$/.test(cardNumber)) {
                    e.preventDefault();
                    alert('Please enter a valid 8-digit card number');
                    return;
                }
                
                // Basic validation for expiry date and CVV
                if(!expiryDate || !cvv) {
                    e.preventDefault();
                    alert('Please fill in all card details');
                    return;
                }
            }
        });
    </script>
</body>
</html>
<?php ob_end_flush(); // End output buffering and send content ?>