<?php
include('header.php');
include('../connect/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Doctors</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .doctor-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .doctor-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn-quick-view {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-quick-view:hover {
            background: linear-gradient(135deg, #5a7ac0 0%, #7c2ebf 100%);
            transform: translateY(-2px);
            color: white;
        }
        .specialty-badge {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 10px;
        }
        .modal-content {
            border: none;
            border-radius: 15px;
        }
        .modal-header {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
            color: white;
            border: none;
            border-radius: 15px 15px 0 0;
        }
        .modal-body {
            padding: 2rem;
        }
        .schedule-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Our Doctors</h2>
        <div class="row">
            <?php
            $select_query = "SELECT * FROM doctors ORDER BY name ASC";
            $result = mysqli_query($con, $select_query);
            
            if(mysqli_num_rows($result) > 0) {
                while($doctor = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card doctor-card shadow">
                            <div class="card-body text-center">
                                <img src="../admin/doctors/upload/<?php echo $doctor['image']; ?>" alt="<?php echo $doctor['name']; ?>" class="doctor-image mb-3">
                                <h4 class="card-title"><?php echo $doctor['name']; ?></h4>
                                <div class="specialty-badge mb-2"><?php echo $doctor['specialty']; ?></div>
                                <p class="card-text">
                                    <strong><i class="fas fa-hospital me-2"></i></strong><?php echo $doctor['hospital']; ?><br>
                                    <strong><i class="fas fa-money-bill me-2"></i></strong><?php echo $doctor['fee']; ?> Taka
                                </p>
                                <div class="mt-3 d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-quick-view" data-bs-toggle="modal" data-bs-target="#doctorModal<?php echo $doctor['id']; ?>">
                                        <i class="fas fa-eye me-2"></i>Quick View
                                    </button>
                                    <a href="book_appointment.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-calendar-check me-2"></i>Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Quick View -->
                    <div class="modal fade" id="doctorModal<?php echo $doctor['id']; ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Doctor Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img src="../admin/doctors/upload/<?php echo $doctor['image']; ?>" alt="<?php echo $doctor['name']; ?>" class="doctor-image mb-3">
                                        </div>
                                        <div class="col-md-8">
                                            <h3><?php echo $doctor['name']; ?></h3>
                                            <div class="specialty-badge mb-3"><?php echo $doctor['specialty']; ?></div>
                                            <p><i class="fas fa-hospital me-2"></i><?php echo $doctor['hospital']; ?></p>
                                            <p><i class="fas fa-money-bill me-2"></i>Consultation Fee: <?php echo $doctor['fee']; ?> Taka</p>
                                            <p><i class="fas fa-user me-2"></i>Age: <?php echo $doctor['age']; ?> | Gender: <?php echo $doctor['gender']; ?></p>
                                            <div class="schedule-info">
                                                <h5 class="mb-3"><i class="fas fa-clock me-2"></i>Schedule</h5>
                                                <p class="mb-2"><strong>Morning:</strong> <?php echo $doctor['morning_schedule']; ?></p>
                                                <p><strong>Evening:</strong> <?php echo $doctor['evening_schedule']; ?></p>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>About Doctor</h5>
                                                <p><?php echo $doctor['description']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="book_appointment.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn btn-primary">
                                        <i class="fas fa-calendar-check me-2"></i>Book Appointment
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-user-md fa-4x text-muted mb-3"></i>
                        <h3 class="text-muted">No Doctors Available</h3>
                        <p class="text-muted mb-4">We currently don\'t have any doctors listed. Please check back later.</p>
                        <div class="d-inline-block p-4 bg-light rounded-3">
                            <p class="mb-0">
                                <i class="fas fa-clock text-primary me-2"></i>
                                We\'re working on expanding our medical team
                            </p>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html> 