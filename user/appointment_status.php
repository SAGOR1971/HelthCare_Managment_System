<?php
ob_start();
include('../connect/config.php');
include('header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all appointments with doctor details and notifications
$query = "SELECT a.*, 
          d.name as doctor_name, d.specialty, d.image as doctor_image,
          n.message as notification_message, n.created_at as notification_time
          FROM tblappointments a 
          JOIN doctors d ON a.doctor_id = d.id 
          LEFT JOIN notifications n ON n.user_id = a.user_id AND n.appointment_id = a.id
          WHERE a.user_id = ? 
          ORDER BY a.appointment_date DESC, a.created_at DESC";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .appointment-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .doctor-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .status-Pending { color: #ffc107; }
        .status-Confirmed { color: #28a745; }
        .status-Completed { color: #17a2b8; }
        .status-Cancelled { color: #dc3545; }
        .notification-message {
            padding: 10px;
            margin-top: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">My Appointments</h2>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($appointment = $result->fetch_assoc()): ?>
                <div class="card appointment-card">
                    <div class="card-body">
            <div class="row">
                            <div class="col-md-2 text-center">
                                <img src="../admin/doctors/upload/<?php echo $appointment['doctor_image']; ?>" 
                                     alt="Doctor" class="doctor-image mb-2">
                </div>
                            <div class="col-md-6">
                                <h4>Dr. <?php echo htmlspecialchars($appointment['doctor_name']); ?></h4>
                                <p class="text-muted"><?php echo htmlspecialchars($appointment['specialty']); ?></p>
                                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?></p>
                                <p><strong>Time:</strong> <?php echo ucfirst($appointment['time_slot']); ?></p>
                                <p><strong>Payment Method:</strong> <?php echo ucfirst($appointment['payment_method']); ?></p>
                                <p><strong>Amount:</strong> <?php echo number_format($appointment['amount_paid'], 2); ?> TaKa</p>
            </div>
                            <div class="col-md-4">
                                <div class="text-end">
                                    <h5>Status: 
                                        <span class="status-<?php echo $appointment['status']; ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </h5>
                                    <p><strong>Booked on:</strong> <?php echo date('M j, Y g:i A', strtotime($appointment['created_at'])); ?></p>
                                                </div>
                                            </div>
                        </div>
                        
                        <?php if ($appointment['status'] === 'Cancelled' && $appointment['notification_message']): ?>
                            <div class="notification-message">
                                <?php echo htmlspecialchars($appointment['notification_message']); ?>
                                <small class="d-block text-muted mt-1">
                                    <?php echo date('M j, Y g:i A', strtotime($appointment['notification_time'])); ?>
                                </small>
                                        </div>
                                    <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">
                You don't have any appointments yet. 
                <a href="doctors.php" class="alert-link">Book an appointment now</a>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 
<?php ob_end_flush(); ?> 
<?php ob_end_flush(); ?> 