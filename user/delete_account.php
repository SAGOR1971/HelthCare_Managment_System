<?php
session_start();
include '../connect/config.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirm_delete']) && isset($_POST['password'])) {
        $password = $_POST['password'];
        
        // Get user's stored password
        $query = "SELECT * FROM tbluser WHERE Id = '$user_id'";
        $result = mysqli_query($con, $query);
        $user_data = mysqli_fetch_assoc($result);
        
        // Compare passwords directly since they might not be hashed in the database
        if ($password === $user_data['Password']) {
            // Start transaction
            mysqli_begin_transaction($con);
            
            try {
                // Delete from tblcart
                mysqli_query($con, "DELETE FROM tblcart WHERE user_id = '$user_id'");
                
                // Delete from tblorders
                mysqli_query($con, "DELETE FROM tblorders WHERE user_id = '$user_id'");
                
                // First delete reward points history related to appointments
                mysqli_query($con, "DELETE FROM reward_point_history WHERE user_id = '$user_id'");
                
                // First delete notifications related to appointments
                $get_appointments = "SELECT id FROM tblappointments WHERE user_id = '$user_id'";
                $appointments_result = mysqli_query($con, $get_appointments);
                
                while ($appointment = mysqli_fetch_assoc($appointments_result)) {
                    mysqli_query($con, "DELETE FROM notifications WHERE appointment_id = '{$appointment['id']}'");
                }
                
                // Then delete user's notifications that aren't linked to appointments
                mysqli_query($con, "DELETE FROM notifications WHERE user_id = '$user_id' AND appointment_id IS NULL");
                
                // Delete from tblappointment if exists
                mysqli_query($con, "DELETE FROM tblappointments WHERE user_id = '$user_id'");
                
                // Finally delete the user account
                mysqli_query($con, "DELETE FROM tbluser WHERE Id = '$user_id'");
                
                // If everything is successful, commit the transaction
                mysqli_commit($con);
                session_destroy();
                echo "<script>alert('Account deleted successfully!'); window.location.href='form/login.php';</script>";
                exit();
                
            } catch (Exception $e) {
                // If there's an error, rollback the changes
                mysqli_rollback($con);
                $error_message = "Error deleting account: " . $e->getMessage();
            }
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Accccount</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="text-center">Delete Account</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> This action cannot be undone. All your data will be permanently deleted, including:
                        <ul>
                            <li>Your profile information</li>
                            <li>Your order history</li>
                            <li>Your shopping cart items</li>
                            <li>Your appointments</li>
                        </ul>
                    </div>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm your password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="confirm_delete" name="confirm_delete" required>
                            <label class="form-check-label" for="confirm_delete">
                                I understand that this action cannot be undone
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                            <a href="index.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<?php include 'footer.php'; ?>
</body>
</html>