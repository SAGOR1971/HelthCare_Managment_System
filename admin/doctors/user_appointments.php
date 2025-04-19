<?php
session_start();
include('../../connect/config.php');  // Changed path to point to correct config file

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");  // Changed path to admin login
    exit();
}

// Handle appointment status updates
if (isset($_POST['update_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['new_status'];
    
    // Start transaction
    mysqli_begin_transaction($con);
    
    try {
        // Get appointment details first
        $get_appointment = "SELECT a.*, u.Id as user_id, u.reward_points, u.Email as user_email 
                          FROM tblappointments a 
                          JOIN tbluser u ON a.user_id = u.Id 
                          WHERE a.id = ?";
        $stmt = $con->prepare($get_appointment);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $appointment = $stmt->get_result()->fetch_assoc();
        
        // Update appointment status
        $update_query = "UPDATE tblappointments SET status = ? WHERE id = ?";
        $stmt = $con->prepare($update_query);
        $stmt->bind_param("si", $new_status, $appointment_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update appointment status");
        }
        
        // Handle different status changes
        if ($new_status === 'Confirmed') {
            // Only give reward points if payment method is card payment
            if ($appointment['payment_method'] === 'card') {
                // Calculate reward points (10% of appointment fee)
                $reward_points = $appointment['amount_paid'] * 0.10;
                
                // Update user's reward points
                $update_points = "UPDATE tbluser SET reward_points = reward_points + ? WHERE Id = ?";
                $stmt = $con->prepare($update_points);
                $stmt->bind_param("di", $reward_points, $appointment['user_id']);
                
                if (!$stmt->execute()) {
                    throw new Exception("Failed to update reward points");
                }
                
                $_SESSION['success'] = "Appointment confirmed and " . number_format($reward_points, 2) . " reward points added to user!";
            } else {
                $_SESSION['success'] = "Appointment confirmed successfully!";
            }
        } 
        elseif ($new_status === 'Cancelled') {
            // Check if appointment was previously confirmed and paid by card (need to deduct reward points)
            if ($appointment['status'] === 'Confirmed' && $appointment['payment_method'] === 'card') {
                // Calculate the reward points that were added (10% of appointment fee)
                $deduct_points = $appointment['amount_paid'] * 0.10;
                
                // Deduct the reward points
                $update_points = "UPDATE tbluser SET reward_points = reward_points - ? WHERE Id = ?";
                $stmt = $con->prepare($update_points);
                $stmt->bind_param("di", $deduct_points, $appointment['user_id']);
                
                if (!$stmt->execute()) {
                    throw new Exception("Failed to deduct reward points");
                }
            }
            
            // For all cancelled appointments, add notification
            $check_notification = "SELECT id FROM notifications WHERE appointment_id = ? LIMIT 1";
            $stmt = $con->prepare($check_notification);
            $stmt->bind_param("i", $appointment_id);
            $stmt->execute();
            $existing_notification = $stmt->get_result()->fetch_assoc();
            
            // Only insert notification if one doesn't exist
            if (!$existing_notification) {
                $notification_query = "INSERT INTO notifications (user_id, appointment_id, message, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $con->prepare($notification_query);
                $message = $appointment['payment_method'] === 'reward_points' 
                    ? "Your appointment has been cancelled. Reward points will be automatically refunded."
                    : "Your appointment has been cancelled. Your payment will be refunded within 24 hours.";
                $stmt->bind_param("iis", $appointment['user_id'], $appointment_id, $message);
                $stmt->execute();
            }
            
            $_SESSION['success'] = "Appointment cancelled successfully.";
        } 
        else {
            $_SESSION['success'] = "Appointment status updated successfully!";
        }
        
        // Commit transaction
        mysqli_commit($con);
        
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($con);
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
    
    // Redirect to remove POST data
    header("Location: user_appointments.php");
    exit();
}

// Fetch all appointments with user and doctor details
$query = "SELECT a.*, 
          u.username as patient_name, u.Email as patient_email, u.Number as patient_phone,
          d.name as doctor_name, d.specialty, d.image as doctor_image
          FROM tblappointments a
          JOIN tbluser u ON a.user_id = u.Id
          JOIN doctors d ON a.doctor_id = d.id
          ORDER BY a.appointment_date DESC, a.created_at DESC";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #2ecc71;
            --warning-color: #f1c40f;
            --info-color: #3498db;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .appointment-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
        }
        
        .doctor-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--secondary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .status-Pending {
            background-color: var(--warning-color);
            color: white;
        }
        
        .status-Confirmed {
            background-color: var(--success-color);
            color: white;
        }
        
        .status-Completed {
            background-color: var(--info-color);
            color: white;
        }
        
        .status-Cancelled {
            background-color: var(--accent-color);
            color: white;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.5rem;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 3px;
        }
        
        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }
        
        .info-value {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-primary">
        <div class="container-fluid text-white">
            <a href="../mystore.php" class="navbar-brand text-white"><h1>Medical Store</h1></a>
            <span>
                <i class="fa-solid fa-user-tie"></i>
                Hello, <?php echo $_SESSION['admin']; ?> |
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="../form/login.php" class="text-decoration-none text-white">Logout</a> |
                <a href="../../user/index.php" class="text-decoration-none text-white">Users Panel</a>
            </span>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="section-title">Manage Appointments</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <div class="appointment-card">
                        <div class="row align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="../../admin/doctors/upload/<?php echo $row['doctor_image']; ?>" 
                                     alt="Doctor" class="doctor-image">
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Doctor</div>
                                <div class="info-value">Dr. <?php echo htmlspecialchars($row['doctor_name']); ?></div>
                                <div class="text-muted"><?php echo htmlspecialchars($row['specialty']); ?></div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Patient</div>
                                <div class="info-value"><?php echo htmlspecialchars($row['patient_name']); ?></div>
                                <div class="text-muted">
                                    <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($row['patient_email']); ?><br>
                                    <i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($row['patient_phone']); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-label">Appointment</div>
                                <div class="info-value">
                                    <i class="far fa-calendar me-1"></i><?php echo date('F j, Y', strtotime($row['appointment_date'])); ?><br>
                                    <i class="far fa-clock me-1"></i><?php echo ucfirst($row['time_slot']); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="info-label">Status</div>
                                <div class="status-badge status-<?php echo $row['status']; ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="info-label">Payment Information</div>
                                <div class="info-value">
                                    <i class="fas fa-credit-card me-1"></i><?php echo ucfirst($row['payment_method']); ?><br>
                                    <i class="fas fa-money-bill-wave me-1"></i><?php echo number_format($row['amount_paid'], 2); ?> Taka
                                </div>
                            </div>
                            <?php if ($row['status'] != 'Cancelled'): ?>
                                <div class="col-md-6 text-end">
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                        <div class="input-group">
                                            <select name="new_status" class="form-select" required>
                                                <option value="">Change Status</option>
                                                <option value="Confirmed">Confirm</option>
                                                <option value="Completed">Complete</option>
                                                <option value="Cancelled">Cancel</option>
                                            </select>
                                            <button type="submit" name="update_status" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h4>No Appointments</h4>
                    <p class="text-muted">There are no appointments to display at the moment.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>