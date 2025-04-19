<?php
include '../../connect/config.php';

if (isset($_POST['submit'])) {
    // Get product details
    $product_name = mysqli_real_escape_string($con, $_POST['Pname']);
    $product_price = mysqli_real_escape_string($con, $_POST['Pprice']);
    $product_image = $_FILES['Pimage'];
    $image_loc = $_FILES['Pimage']['tmp_name'];    
    $image_name = $_FILES['Pimage']['name'];
    $image_des = "Upload_image/" . $image_name; 
    move_uploaded_file($image_loc, "Upload_image/" . $image_name);

    // Get the description and category selected by the admin
    $product_description = mysqli_real_escape_string($con, $_POST['Pdescription']); // Get description from form
    $product_category = mysqli_real_escape_string($con, $_POST['Pages']); // Category selected (e.g., Medicine, Syrup, Equipment)

    // Insert the product into the selected category
    $insert_query = "INSERT INTO `tblproduct`(`Pname`, `Pprice`, `Pimage`, `Pcategory`, `Pdescription`) 
                     VALUES ('$product_name', '$product_price', '$image_des', '$product_category', '$product_description')";

    if (!mysqli_query($con, $insert_query)) {
        die("Error inserting into category: " . mysqli_error($con));
    }

    // Insert the product into the "Home" category (this will automatically add it to the Home page)
    $insert_home_query = "INSERT INTO `tblproduct`(`Pname`, `Pprice`, `Pimage`, `Pcategory`, `Pdescription`) 
                          VALUES ('$product_name', '$product_price', '$image_des', 'Home', '$product_description')";

    if (!mysqli_query($con, $insert_home_query)) {
        die("Error inserting into home: " . mysqli_error($con));
    }

    // Set success message and redirect
    echo "<script>
        alert('Product added successfully!');
        window.location.href='index.php';
    </script>";
    exit();
}
?>
