<?php
header('Content-Type: application/json');
include('../connect/config.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['appointment_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION['user_id'];
$appointment_id = $_POST['appointment_id'];

// Start transaction
mysqli_begin_transaction($con);

try {
    // Get appointment details first
    $query = "SELECT * FROM tblappointments WHERE id = ? AND user_id = ? AND status = 'Pending'";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $appointment_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Appointment not found or cannot be cancelled");
    }
    
    $appointment = $result->fetch_assoc();
    
    // If payment was made with reward points, refund them
    if ($appointment['payment_method'] === 'reward_points') {
        $refund_query = "UPDATE tbluser SET reward_points = reward_points + ? WHERE Id = ?";
        $stmt = $con->prepare($refund_query);
        $stmt->bind_param("di", $appointment['amount_paid'], $user_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to refund reward points");
        }
    }
    
    // Update appointment status to Cancelled
    $update_query = "UPDATE tblappointments SET status = 'Cancelled' WHERE id = ? AND user_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param("ii", $appointment_id, $user_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to cancel appointment");
    }
    
    // If everything is successful, commit the transaction
    mysqli_commit($con);
    
    echo json_encode(['success' => true]);
    
} catch (Exception $e) {
    // If there's an error, rollback the transaction
    mysqli_rollback($con);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 