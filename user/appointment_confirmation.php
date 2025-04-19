<?php
ob_start(); // Start output buffering
include('../connect/config.php');
include('header.php');

// Check if there's a success message or if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['success_message'])) {
    header("Location: doctors.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the last booked appointment details for the user
$query = "SELECT a.id, a.appointment_date, a.time_slot, a.payment_method, a.amount_paid, a.status, d.name AS doctor_name, d.specialty 
          FROM tblappointments a 
          JOIN doctors d ON a.doctor_id = d.id 
          WHERE a.user_id = ? ORDER BY a.created_at DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error_message'] = "No appointment found!";
    header("Location: doctors.php");
    exit();
}

$appointment = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJQ3X4bbp7p9t4ZqYcK9IcfupDO0aKOnf0e1zI6P1mQ7BQ6woZbZk0SkBdg0" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .confirmation-container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .confirmation-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .confirmation-header h2 {
            color: #28a745;
            font-size: 2rem;
            font-weight: bold;
        }
        .appointment-details {
            margin-bottom: 20px;
        }
        .appointment-details p {
            font-size: 16px;
        }
        .appointment-details .value {
            font-weight: bold;
            color: #555;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 10px 20px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-container">
            <div class="confirmation-header">
                <h2>Appointment Confirmed!</h2>
            </div>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger error-message">
                    <?php
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="appointment-details">
                <p><strong>Doctor:</strong> <span class="value">Dr. <?php echo $appointment['doctor_name']; ?></span></p>
                <p><strong>Specialty:</strong> <span class="value"><?php echo $appointment['specialty']; ?></span></p>
                <p><strong>Appointment Date:</strong> <span class="value"><?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?></span></p>
                <p><strong>Time Slot:</strong> <span class="value"><?php echo ucfirst($appointment['time_slot']); ?></span></p>
                <p><strong>Payment Method:</strong> <span class="value"><?php echo ucfirst($appointment['payment_method']); ?></span></p>
                <p><strong>Amount Paid:</strong> <span class="value"><?php echo number_format($appointment['amount_paid'], 2); ?> TaKa</span></p>
                <p><strong>Status:</strong> <span class="value"><?php echo ucfirst($appointment['status']); ?></span></p>
            </div>

            <div class="d-flex justify-content-between">
            <a href="doctors.php" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">← Back to Doctors</a>
    <a href="appointment_status.php" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">View My Appointments →</a>
       </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybP8fdWzGv7v3L1g4Z8vCFAmO7gN2w6w7h2aFzY5eTcW/dzV6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Y4F6EqvYQjtLrh30Hu4gk9G4Eg49/tf4Y0S2zPmbxkxxQWi" crossorigin="anonymous"></script>
</body>
</html>

<?php
ob_end_flush(); // End output buffering and send content
?>
