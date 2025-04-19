<?php
include('header.php');
include('../connect/config.php');

if(!isset($_SESSION['user'])){
    echo "<script>
        alert('Please login first to book an appointment!');
        window.location.href='form/login.php';
    </script>";
    exit();
}

if(!isset($_GET['doctor_id'])){
    header("location:doctors.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM tbluser WHERE Id = $user_id";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Get doctor details
$doctor_id = $_GET['doctor_id'];
$doctor_query = "SELECT * FROM doctors WHERE id = $doctor_id";
$doctor_result = mysqli_query($con, $doctor_query);
$doctor = mysqli_fetch_assoc($doctor_result);

if(!$doctor) {
    header("location:doctors.php");
    exit();
}

// Handle form submission
if(isset($_POST['book_appointment'])) {
    $appointment_date = $_POST['appointment_date'];
    $time_slot = $_POST['time_slot'];
    
    // Check if appointment slot is available
    $check_query = "SELECT * FROM appointments WHERE doctor_id = $doctor_id AND appointment_date = '$appointment_date' AND time_slot = '$time_slot' AND status != 'rejected'";
    $check_result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('This time slot is already booked. Please choose another.');</script>";
    } else {
        $insert_query = "INSERT INTO appointments (user_id, doctor_id, appointment_date, time_slot, status) 
                        VALUES ($user_id, $doctor_id, '$appointment_date', '$time_slot', 'pending')";
        
        if(mysqli_query($con, $insert_query)) {
            echo "<script>
                alert('Appointment booked successfully! Please wait for confirmation.');
                window.location.href='appointment_status.php';
            </script>";
        } else {
            echo "<script>alert('Failed to book appointment. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Book Appointment with Dr. <?php echo $doctor['name']; ?></h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-4 text-center">
                                <img src="../admin/doctors/upload/<?php echo $doctor['image']; ?>" alt="<?php echo $doctor['name']; ?>" class="img-fluid rounded" style="max-width: 200px;">
                            </div>
                            <div class="col-md-8">
                                <h5>Doctor Details:</h5>
                                <p><strong>Specialty:</strong> <?php echo $doctor['specialty']; ?></p>
                                <p><strong>Hospital:</strong> <?php echo $doctor['hospital']; ?></p>
                                <p><strong>Consultation Fee:</strong> <?php echo $doctor['fee']; ?> Taka</p>
                                <p><strong>Available Times:</strong><br>
                                Morning: <?php echo $doctor['morning_schedule']; ?><br>
                                Evening: <?php echo $doctor['evening_schedule']; ?></p>
                            </div>
                        </div>

                        <form method="POST" action="appointment_checkout.php">
                            <input type="hidden" name="book_appointment" value="1">
                            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Your Name</label>
                                    <input type="text" class="form-control" value="<?php echo $user['username']; ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Your Email</label>
                                    <input type="email" class="form-control" value="<?php echo $user['Email']; ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Your Phone</label>
                                    <input type="text" class="form-control" value="<?php echo $user['Number']; ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Appointment Date</label>
                                    <input type="date" name="appointment_date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Preferred Time Slot</label>
                                <select name="time_slot" class="form-select" required>
                                    <option value="">Select Time Slot</option>
                                    <option value="morning">Morning (<?php echo $doctor['morning_schedule']; ?>)</option>
                                    <option value="evening">Evening (<?php echo $doctor['evening_schedule']; ?>)</option>
                                </select>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
                                <a href="doctors.php" class="btn btn-secondary">Cancel</a>
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