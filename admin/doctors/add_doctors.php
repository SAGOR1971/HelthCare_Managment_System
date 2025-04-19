<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <?php
    session_start();
    if(!$_SESSION['admin']){
        header("location:../form/login.php");
    }
    ?>
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
                            <h2 class="text-white mb-0">Add New Doctor</h2>
                            <a href="view_doctors.php" class="btn btn-light">
                                <i class="fas fa-list me-2"></i>View Doctors
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="insert_doctor.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="doctorName" placeholder="Enter doctor name" required>
                                        <label for="doctorName">Doctor Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="number" class="form-control" id="phoneNumber" placeholder="Enter phone number" required>
                                        <label for="phoneNumber">Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" required>
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="specialty" class="form-control" id="specialty" placeholder="Enter specialty" required>
                                        <label for="specialty">Specialty</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" name="hospital" class="form-control" id="hospital" placeholder="Enter hospital name" required>
                                    <label for="hospital">Hospital Name</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="morning_schedule" class="form-control" id="morningSchedule" placeholder="e.g. 9:00 AM - 1:00 PM" required>
                                        <label for="morningSchedule">Morning Schedule</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="evening_schedule" class="form-control" id="eveningSchedule" placeholder="e.g. 5:00 PM - 9:00 PM" required>
                                        <label for="eveningSchedule">Evening Schedule</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" name="age" class="form-control" id="age" placeholder="Enter age" required>
                                        <label for="age">Age</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <select name="gender" class="form-select" id="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <label for="gender">Gender</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea name="description" class="form-control" id="description" style="height: 120px" placeholder="Enter description" required></textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="number" name="fee" class="form-control" id="fee" placeholder="Enter consultation fee" required>
                                        <label for="fee">Consultation Fee</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold mb-2">Doctor's Photo</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" name="add_doctor" class="btn btn-primary px-4">
                                    <i class="fas fa-user-md me-2"></i>Add Doctor
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