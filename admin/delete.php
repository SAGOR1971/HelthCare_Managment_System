<?php
include '../connect/config.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['ID'])) {
    $id = $_GET['ID'];

    // Prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);

    // Start transaction
    mysqli_begin_transaction($con);

    try {
        // Delete from tblcart first
        mysqli_query($con, "DELETE FROM tblcart WHERE user_id = '$id'");
        
        // Delete from tblorders
        mysqli_query($con, "DELETE FROM tblorders WHERE user_id = '$id'");
        
        // Delete from tblappointment if exists
        mysqli_query($con, "DELETE FROM tblappointments WHERE user_id = '$id'");
        
        // Finally delete the user
        mysqli_query($con, "DELETE FROM tbluser WHERE Id = '$id'");

        // If everything is successful, commit the transaction
        mysqli_commit($con);
        
        echo "<script>
                alert('User and all related records deleted successfully');
                window.location.href = 'mystore.php';
              </script>";
    } catch (Exception $e) {
        // If there's an error, rollback the changes
        mysqli_rollback($con);
        echo "<script>
                alert('Error deleting user: " . mysqli_error($con) . "');
                window.location.href = 'mystore.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request');
            window.location.href = 'mystore.php';
          </script>";
}

// Close connection
mysqli_close($con);
?>
