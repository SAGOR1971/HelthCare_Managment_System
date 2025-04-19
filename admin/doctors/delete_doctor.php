<?php
session_start();
if(!$_SESSION['admin']){
    header("location:../form/login.php");
}
include('../../connect/config.php');

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Get the image name before deleting
    $select_query = "SELECT image FROM doctors WHERE id = '$id'";
    $result = mysqli_query($con, $select_query);
    
    if (!$result) {
        die("Error in select query: " . mysqli_error($con));
    }
    
    $doctor = mysqli_fetch_assoc($result);
    
    // First, get all appointments for this doctor
    $get_appointments = "SELECT id FROM tblappointments WHERE doctor_id = '$id'";
    $appointments_result = mysqli_query($con, $get_appointments);
    
    if (!$appointments_result) {
        die("Error getting appointments: " . mysqli_error($con));
    }
    
    // Delete notifications for each appointment
    while ($appointment = mysqli_fetch_assoc($appointments_result)) {
        // Delete reward points history for this appointment
        $delete_reward_points = "DELETE FROM reward_point_history WHERE appointment_id = '{$appointment['id']}'";
        if (!mysqli_query($con, $delete_reward_points)) {
            die("Error deleting reward points history: " . mysqli_error($con));
        }
        
        $delete_notifications = "DELETE FROM notifications WHERE appointment_id = '{$appointment['id']}'";
        if (!mysqli_query($con, $delete_notifications)) {
            die("Error deleting notifications: " . mysqli_error($con));
        }
    }
    
    // Now delete all appointments
    $delete_appointments = "DELETE FROM tblappointments WHERE doctor_id = '$id'";
    $appointment_result = mysqli_query($con, $delete_appointments);
    
    if (!$appointment_result) {
        die("Error deleting appointments: " . mysqli_error($con));
    }
    
    // Finally delete the doctor record
    $delete_query = "DELETE FROM doctors WHERE id = '$id'";
    
    if(mysqli_query($con, $delete_query)) {
        // Delete the image file if it exists
        if($doctor['image'] && file_exists("upload/" . $doctor['image'])) {
            unlink("upload/" . $doctor['image']);
        }
        
        echo "<script>
            alert('Doctor deleted successfully!');
            window.location.href='view_doctors.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to delete doctor: " . mysqli_error($con) . "');
            window.location.href='view_doctors.php';
        </script>";
    }
} else {
    header("location:view_doctors.php");
}