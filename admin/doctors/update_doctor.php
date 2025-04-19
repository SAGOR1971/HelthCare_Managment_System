<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location:../form/login.php");
    exit();
}
include('../../connect/config.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $select_query = "SELECT * FROM doctors WHERE id = $id";
    $result = mysqli_query($con, $select_query);
    $doctor = mysqli_fetch_assoc($result);
}

if(isset($_POST['update_doctor'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $specialty = $_POST['specialty'];
    $hospital = $_POST['hospital'];
    $morning_schedule = $_POST['morning_schedule'];
    $evening_schedule = $_POST['evening_schedule'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    $fee = $_POST['fee'];
    $old_image = $_POST['old_image'];

    if($_FILES['image']['name'] != '') {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png');
        
        if(in_array($image_ext, $allowed_types)) {
            $new_image_name = time() . '_' . $image;
            move_uploaded_file($tmp_name, "upload/" . $new_image_name);
            if(file_exists("upload/" . $old_image)) {
                unlink("upload/" . $old_image);
            }
        } else {
            echo "<script>alert('Invalid image format!');</script>";
            $new_image_name = $old_image;
        }
    } else {
        $new_image_name = $old_image;
    }

    $update_query = "UPDATE doctors SET 
        name = '$name',
        number = '$number',
        email = '$email',
        specialty = '$specialty',
        hospital = '$hospital',
        morning_schedule = '$morning_schedule',
        evening_schedule = '$evening_schedule',
        age = $age,
        gender = '$gender',
        description = '$description',
        fee = $fee,
        image = '$new_image_name'
        WHERE id = $id";
    
    if(mysqli_query($con, $update_query)) {
        echo "<script>
            alert('Doctor updated successfully!');
            window.location.href='view_doctors.php';
        </script>";
    } else {
        echo "<script>alert('Failed to update doctor!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-gradient-primary border-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="text-white mb-0">Update Doctor</h2>
                            <a href="view_doctors.php" class="btn btn-light">
                                <i class="fas fa-list me-2"></i>View Doctors
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $doctor['id']; ?>">
                            <input type="hidden" name="old_image" value="<?php echo $doctor['image']; ?>">
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="doctorName" value="<?php echo $doctor['name']; ?>" required>
                                        <label for="doctorName">Doctor Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="number" class="form-control" id="phoneNumber" value="<?php echo $doctor['number']; ?>" required>
                                        <label for="phoneNumber">Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $doctor['email']; ?>" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="specialty" class="form-control" id="specialty" value="<?php echo $doctor['specialty']; ?>" required>
                                        <label for="specialty">Specialty</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" name="hospital" class="form-control" id="hospital" value="<?php echo $doctor['hospital']; ?>" required>
                                    <label for="hospital">Hospital Name</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="morning_schedule" class="form-control" id="morningSchedule" value="<?php echo $doctor['morning_schedule']; ?>" required>
                                        <label for="morningSchedule">Morning Schedule</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="evening_schedule" class="form-control" id="eveningSchedule" value="<?php echo $doctor['evening_schedule']; ?>" required>
                                        <label for="eveningSchedule">Evening Schedule</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" name="age" class="form-control" id="age" value="<?php echo $doctor['age']; ?>" required>
                                        <label for="age">Age</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <select name="gender" class="form-select" id="gender" required>
                                            <option value="Male" <?php echo ($doctor['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo ($doctor['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                            <option value="Other" <?php echo ($doctor['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea name="description" class="form-control" id="description" style="height: 120px" required><?php echo $doctor['description']; ?></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" name="fee" class="form-control" id="fee" value="<?php echo $doctor['fee']; ?>" required>
                                        <label for="fee">Consultation Fee</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold mb-2">Doctor's Photo</label>
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <img src="upload/<?php echo $doctor['image']; ?>" class="rounded shadow-sm" alt="Current Image" style="width: 100px; height: 90px; object-fit: cover;">
                                        <div class="text-muted small">Current Image</div>
                                    </div>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <div class="form-text">Leave blank to keep current image</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="view_doctors.php" class="btn btn-secondary px-4">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" name="update_doctor" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Update Doctor
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            background: #fff;
            transition: all 0.3s ease;
        }
        .card-header {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
        }
        .form-control, .form-select {
            border: 1px solid #dce4ec;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #8E37D7;
            box-shadow: 0 0 0 0.25rem rgba(142, 55, 215, 0.25);
        }
        .form-floating > label {
            padding: 0.75rem;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a7ac0 0%, #7c2ebf 100%);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #2c3e50;
            border: none;
        }
        .btn-secondary:hover {
            background: #1a252f;
            transform: translateY(-2px);
        }
        .btn-light {
            background: rgba(255,255,255,0.9);
            border: none;
            font-weight: 500;
        }
        .btn-light:hover {
            background: #fff;
            transform: translateY(-2px);
        }
        textarea.form-control {
            min-height: 120px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 