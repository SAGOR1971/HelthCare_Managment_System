<?php
session_start();
include('../../connect/config.php');

if(isset($_POST['add_doctor'])) {
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

    // Image upload handling
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed_types = array('jpg', 'jpeg', 'png');
    
    if(in_array($image_ext, $allowed_types)) {
        $new_image_name = time() . '_' . $image;
        move_uploaded_file($tmp_name, "upload/" . $new_image_name);

        // Insert into doctors table
        $insert_query = "INSERT INTO doctors (name, number, email, specialty, hospital, morning_schedule, evening_schedule, age, gender, description, fee, image) 
                        VALUES ('$name', '$number', '$email', '$specialty', '$hospital', '$morning_schedule', '$evening_schedule', $age, '$gender', '$description', $fee, '$new_image_name')";
        
        if(mysqli_query($con, $insert_query)) {
            echo "<script>
                alert('Doctor added successfully!');
                window.location.href='add_doctors.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to add doctor. Please try again.');
                window.location.href='add_doctors.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid image format. Please use JPG, JPEG or PNG.');
            window.location.href='add_doctors.php';
        </script>";
    }
} 