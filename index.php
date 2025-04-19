<?php
include 'header.php';

// Handle contact form submission
if(isset($_POST['send_message'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $insert_query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if(mysqli_query($con, $insert_query)) {
        echo "<script>alert('Thank you for your message! We will get back to you soon.');</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.');</script>";
    }
}

// Fetch About Us content
$about_query = "SELECT * FROM about_us LIMIT 1";
$about_result = mysqli_query($con, $about_query);
$about = mysqli_fetch_assoc($about_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthcare Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .about-section {
            padding: 50px 0;
            background-color: #f8f9fa;
        }
        .contact-section {
            padding: 50px 0;
        }
        .info-box {
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <h1 class="text-warning"><?php echo $about['title'] ?? 'About Us'; ?></h1>
                    <p class="lead"><?php echo $about['description'] ?? ''; ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h3 class="text-warning">Our Mission</h3>
                        <p><?php echo $about['mission'] ?? ''; ?></p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="info-box">
                        <h3 class="text-warning">Our Vision</h3>
                        <p><?php echo $about['vision'] ?? ''; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section bg-light">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-4">
                    <div class="info-box">
                        <h3 class="text-warning mb-4">Contact Information</h3>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo $about['address'] ?? ''; ?></p>
                        <p><i class="fas fa-phone"></i> <?php echo $about['phone'] ?? ''; ?></p>
                        <p><i class="fas fa-envelope"></i> <?php echo $about['email'] ?? ''; ?></p>
                        <p><i class="fas fa-clock"></i> <?php echo $about['working_hours'] ?? ''; ?></p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-md-8">
                    <div class="info-box">
                        <h3 class="text-warning mb-4">Send us a Message</h3>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" name="send_message" class="btn btn-warning">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html> 