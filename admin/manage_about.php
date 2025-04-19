<?php
session_start();
include('../connect/config.php');

// Check if admin is logged in
if(!isset($_SESSION['admin'])) {
    echo "<script>
        alert('Please login first!');
        window.location.href='form/login.php';
    </script>";
    exit();
}

// Handle form submission
if(isset($_POST['update_about'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $mission = mysqli_real_escape_string($con, $_POST['mission']);
    $vision = mysqli_real_escape_string($con, $_POST['vision']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $working_hours = mysqli_real_escape_string($con, $_POST['working_hours']);

    // Check if record exists
    $check_query = "SELECT id FROM about_us LIMIT 1";
    $check_result = mysqli_query($con, $check_query);

    if(mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $update_query = "UPDATE about_us SET 
            title = '$title',
            description = '$description',
            mission = '$mission',
            vision = '$vision',
            address = '$address',
            phone = '$phone',
            email = '$email',
            working_hours = '$working_hours'
            WHERE id = 1";
        
        if(mysqli_query($con, $update_query)) {
            echo "<script>alert('About Us content updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating content: " . mysqli_error($con) . "');</script>";
        }
    } else {
        // Insert new record
        $insert_query = "INSERT INTO about_us (title, description, mission, vision, address, phone, email, working_hours) 
            VALUES ('$title', '$description', '$mission', '$vision', '$address', '$phone', '$email', '$working_hours')";
        
        if(mysqli_query($con, $insert_query)) {
            echo "<script>alert('About Us content added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding content: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Fetch existing content
$fetch_query = "SELECT * FROM about_us LIMIT 1";
$result = mysqli_query($con, $fetch_query);
$about = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage About Us</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
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
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container py-5">
        <h2 class="section-title text-center mb-5">Manage About Us Content</h2>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo $about['title'] ?? ''; ?>" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $about['phone'] ?? ''; ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" required><?php echo $about['description'] ?? ''; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Mission</label>
                            <textarea name="mission" class="form-control" rows="3" required><?php echo $about['mission'] ?? ''; ?></textarea>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Vision</label>
                            <textarea name="vision" class="form-control" rows="3" required><?php echo $about['vision'] ?? ''; ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo $about['email'] ?? ''; ?>" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Working Hours</label>
                            <textarea name="working_hours" class="form-control" rows="2" required><?php echo $about['working_hours'] ?? ''; ?></textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" required><?php echo $about['address'] ?? ''; ?></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="update_about" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Content
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Form Validation -->
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html> 