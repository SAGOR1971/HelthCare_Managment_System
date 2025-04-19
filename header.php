<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect/config.php';

$count = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($con, "SELECT COUNT(*) AS count FROM tblcart WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-light bg-dark text-white">
        <div class="container-fluid">
            <a href="user/about.php" class="navbar-brand fw-bold"><img src="user/logo.png" width="90px" alt="logo"></a>
            <div class="d-flex align-items-center">
                <!-- First Dropdown for Products -->
                <div class="dropdown pe-3">
                    <a class="text-warning text-decoration-none dropdown-toggle" href="#" id="productsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-house"></i> Products
                    </a>
                    <ul class="dropdown-menu bg-dark" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item text-warning" href="user/index.php">All Products</a></li>
                        <li><a class="dropdown-item text-warning" href="user/Medicine.php">Medicine</a></li>
                        <li><a class="dropdown-item text-warning" href="user/Syrup.php">Syrup</a></li>
                        <li><a class="dropdown-item text-warning" href="user/Equipment.php">Equipment</a></li>
                    </ul>
                </div>

                <!-- Second Dropdown for Doctor Services -->
                <div class="dropdown pe-3">
                    <a class="text-warning text-decoration-none dropdown-toggle" href="#" id="doctorsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user-md"></i> Doctors
                    </a>
                    <ul class="dropdown-menu bg-dark" aria-labelledby="doctorsDropdown">
                        <li><a class="dropdown-item text-warning" href="user/doctors.php">Doctor List</a></li>
                        <li><a class="dropdown-item text-warning" href="user/appointment_status.php">Appointment Status</a></li>
                        <li><a class="dropdown-item text-warning" href="user/chat.php">Chat With Ai Doctor</a></li>
                    </ul>
                </div>

                <div class="dropdown pe-3">
                    <a class="text-warning text-decoration-none" href="user/view_cart.php">
                        <i class="fa-solid fa-cart-shopping"></i> Cart
                        <span class="badge bg-danger"><?php echo $count; ?></span>
                    </a>
                </div>
                
                <!-- Reward Points Display -->
                <div class="pe-3">
                    <div class="rounded-circle bg-warning text-dark d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <?php
                        $reward_points = 0;
                        if (isset($_SESSION['user_id'])) {
                            $user_id = $_SESSION['user_id'];
                            $result = mysqli_query($con, "SELECT reward_points FROM tbluser WHERE Id = '$user_id'");
                            if ($row = mysqli_fetch_assoc($result)) {
                                $reward_points = $row['reward_points'];
                            }
                        }
                        echo number_format($reward_points, 0);
                        ?>
                    </div>
                </div>

                <span class="text-warning pe-2">
                    <div class="dropdown d-inline-block">
                        <a class="text-warning text-decoration-none dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Hello, <?php 
                            if(isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id'];
                                $name_query = "SELECT username FROM tbluser WHERE Id = '$user_id'";
                                $name_result = mysqli_query($con, $name_query);
                                if($name_data = mysqli_fetch_assoc($name_result)) {
                                    echo $name_data['username'];
                                }
                            }
                            ?>
                        </a>
                        <?php if(isset($_SESSION['user'])): ?>
                            <ul class="dropdown-menu bg-dark" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item text-warning" href="user/update_profile.php">
                                        <i class="fas fa-user-edit"></i> Update Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-warning" href="user/order_status.php">
                                        <i class="fas fa-box"></i> Order Status
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="user/delete_account.php">
                                        <i class="fas fa-user-times"></i> Delete Account
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider bg-secondary"></li>
                                <li>
                                    <a class="dropdown-item text-warning" href="user/form/logout.php">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        <?php else: ?>
                            <a href="user/form/login.php" class="text-warning text-decoration-none">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        <?php endif; ?>
                    </div>
                </span>
                <a href="admin/mystore.php" class="text-warning text-decoration-none"><i class="fa-solid fa-user-tie"></i> Admin</a>
            </div>
        </div>
    </nav>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle update profile form submission
        var updateProfileForm = document.getElementById('updateProfileForm');
        if (updateProfileForm) {
            updateProfileForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                var modal = bootstrap.Modal.getInstance(document.getElementById('updateProfileModal'));
                if (modal) {
                    modal.hide(); // Hide the modal
                }
                this.submit(); // Submit the form
            });
        }

        // Close modal when clicking outside
        var updateProfileModal = document.getElementById('updateProfileModal');
        if (updateProfileModal) {
            updateProfileModal.addEventListener('hidden.bs.modal', function () {
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });
        }
    });
    </script>
</body>
</html>