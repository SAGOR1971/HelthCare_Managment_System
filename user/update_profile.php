<?php
session_start();
include '../connect/config.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: form/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tbluser WHERE Id = '$user_id'";
$result = mysqli_query($con, $query);
$user_data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $number = mysqli_real_escape_string($con, $_POST['number']);
    
    // Check if password is provided, if not, keep the current password
    $password = isset($_POST['password']) && !empty($_POST['password']) 
        ? $_POST['password']  // Use the plain password if provided
        : $user_data['Password'];  // Otherwise, retain the current password

    $update_query = "UPDATE tbluser SET 
        username = '$username',
        Email = '$email',
        Number = '$number',
        Password = '$password'
        WHERE Id = '$user_id'";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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
                <div class="card-header bg-dark text-warning">
                    <h3 class="text-center">Update Profile</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                value="<?php echo htmlspecialchars($user_data['Email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="number" name="number" 
                                value="<?php echo htmlspecialchars($user_data['Number']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-warning">Update Profile</button>
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
