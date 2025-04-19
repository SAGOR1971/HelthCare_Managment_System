<?php
ob_start(); // Start output buffering
include('../connect/config.php');
include('header.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['doctor_id'])) {
    header("Location: doctors.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$doctor_id = $_POST['doctor_id'];
$appointment_date = $_POST['appointment_date'];
$time_slot = $_POST['time_slot'];
$payment_method = $_POST['payment_method'];

// Get doctor details and appointment fee
$doctor_query = "SELECT * FROM doctors WHERE id = ?";
$stmt = mysqli_prepare($con, $doctor_query);
mysqli_stmt_bind_param($stmt, "i", $doctor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$doctor = mysqli_fetch_assoc($result);
$appointment_fee = $doctor['fee'];

// Check if user has enough reward points if using reward points
if ($payment_method == 'reward_points') {
    $user_query = "SELECT reward_points FROM tbluser WHERE Id = ?";
    $stmt = $con->prepare($user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $available_reward_points = $user_data['reward_points'];

    if ($available_reward_points < $appointment_fee) {
        $_SESSION['error_message'] = "Insufficient reward points!";
        header("Location: appointment_checkout.php?doctor_id=$doctor_id&appointment_date=$appointment_date&time_slot=$time_slot");
        exit();
    }

    // Deduct reward points
    $update_points = "UPDATE tbluser SET reward_points = reward_points - ? WHERE Id = ?";
    $stmt = $con->prepare($update_points);
    $stmt->bind_param("di", $appointment_fee, $user_id);
    if (!$stmt->execute()) {
        $_SESSION['error_message'] = "Error processing reward points!";
        header("Location: appointment_checkout.php?doctor_id=$doctor_id&appointment_date=$appointment_date&time_slot=$time_slot");
        exit();
    }
}

// Insert appointment into tblappointments
$insert_appointment_query = "INSERT INTO tblappointments (user_id, doctor_id, appointment_date, time_slot, status, payment_method, amount_paid)
VALUES (?, ?, ?, ?, 'Pending', ?, ?)";
$stmt = $con->prepare($insert_appointment_query);
$stmt->bind_param("iisssd", $user_id, $doctor_id, $appointment_date, $time_slot, $payment_method, $appointment_fee);
$stmt->execute();

// Redirect to a confirmation page or display a success message
$_SESSION['success_message'] = "Appointment successfully booked!";
header("Location: appointment_confirmation.php");
exit();

ob_end_flush(); // End output buffering and send content
?>
