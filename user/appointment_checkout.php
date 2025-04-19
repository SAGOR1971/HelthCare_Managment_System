<?php
ob_start(); // Start output buffering
include('../connect/config.php');
include('header.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['book_appointment'])) {
    header("Location: doctors.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$doctor_id = $_POST['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$time_slot = $_POST['time_slot'];

// Get doctor details and fee
$doctor_query = "SELECT * FROM doctors WHERE id = ?";
$stmt = mysqli_prepare($con, $doctor_query);
mysqli_stmt_bind_param($stmt, "i", $doctor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$doctor = mysqli_fetch_assoc($result);
$appointment_fee = $doctor['fee'];

// Get user's current reward points
$query = "SELECT reward_points FROM tbluser WHERE Id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$available_reward_points = $user_data['reward_points'];

// Calculate required points (1:1 ratio)
$required_points = $appointment_fee;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Appointment Checkout</title>
    <style>
        .payment-section { display: none; }
        .active { display: block; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Appointment Checkout</h2>
        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-body">
                <h4>Appointment Details</h4>
                <p><strong>Doctor:</strong> Dr. <?php echo $doctor['name']; ?></p>
                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($appointment_date)); ?></p>
                <p><strong>Time:</strong> <?php echo ucfirst($time_slot); ?></p>
                <p><strong>Fee:</strong> <?php echo number_format($appointment_fee, 2); ?> TaKa</p>
            </div>
        </div>

        <form id="checkoutForm" method="POST" action="process_appointment.php">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
            <input type="hidden" name="appointment_date" value="<?php echo $appointment_date; ?>">
            <input type="hidden" name="time_slot" value="<?php echo $time_slot; ?>">
            <input type="hidden" name="appointment_fee" value="<?php echo $appointment_fee; ?>">

            <div class="form-group">
                <label>Select Payment Method:</label>
                <select name="payment_method" id="paymentMethod" required class="form-control">
                    <option value="">Select Payment Method</option>
                    <option value="reward_points">Reward Points (Available: <?php echo number_format($available_reward_points, 2); ?>)</option>
                    <option value="card">Card Payment</option>
                </select>
            </div>

            <div id="rewardPointsSection" class="payment-section">
                <p>Appointment Fee: <?php echo number_format($appointment_fee, 2); ?> TaKa</p>
                <p>Required Points: <?php echo number_format($required_points, 2); ?></p>
                <p>Your Points: <?php echo number_format($available_reward_points, 2); ?></p>
                <?php if ($available_reward_points < $required_points): ?>
                <p class="error">You don't have enough reward points for this appointment.</p>
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
            </div>

            <button type="submit" id="payButton" class="btn btn-primary mt-3">Pay Now</button>
            <a href="doctors.php" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const rewardPointsSection = document.getElementById('rewardPointsSection');
            const cardPaymentSection = document.getElementById('cardPaymentSection');
            const payButton = document.getElementById('payButton');
            const availablePoints = <?php echo $available_reward_points; ?>;
            const requiredPoints = <?php echo $required_points; ?>;
            
            rewardPointsSection.classList.remove('active');
            cardPaymentSection.classList.remove('active');
            payButton.disabled = false;
            
            if(this.value === 'reward_points') {
                rewardPointsSection.classList.add('active');
                if(availablePoints < requiredPoints) {
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