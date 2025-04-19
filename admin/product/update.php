<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location:../form/login.php");
    exit();
}

include '../../connect/config.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo "<script>
        alert('No product ID provided!');
        window.location.href='view_products.php';
    </script>";
    exit();
}

$id = $_GET['id'];

// First get the product name
$result = mysqli_query($con, "SELECT * FROM tblproduct WHERE Id='$id'");

// Check if product exists
if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>
        alert('Product not found!');
        window.location.href='view_products.php';
    </script>";
    exit();
}

$row = mysqli_fetch_assoc($result);
$current_name = $row['Pname']; // Store the current name before update

if (isset($_POST['update'])) {
    $Pname = $_POST['Pname'];
    $Pprice = $_POST['Pprice'];
    $Pcategory = $_POST['Pages'];
    
    if (!empty($_FILES['Pimage']['name'])) {
        $image = "Upload_Image/" . basename($_FILES['Pimage']['name']);
        move_uploaded_file($_FILES['Pimage']['tmp_name'], $image);
        
        // Update all entries of this product using the current name
        $query = "UPDATE tblproduct SET 
                 Pname='$Pname', 
                 Pprice='$Pprice', 
                 Pimage='$image'
                 WHERE Pname='$current_name'";
    } else {
        // Update without changing the image
        $query = "UPDATE tblproduct SET 
                 Pname='$Pname', 
                 Pprice='$Pprice'
                 WHERE Pname='$current_name'";
    }

    // Update the category only for the non-Home entry
    $update_category = "UPDATE tblproduct SET 
                       Pcategory='$Pcategory' 
                       WHERE Pname='$Pname' AND Pcategory != 'Home'";

    if (mysqli_query($con, $query) && mysqli_query($con, $update_category)) {
        echo "<script>
            alert('Product updated successfully in all categories!');
            window.location.href='view_products.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating product: " . mysqli_error($con) . "');
            window.location.href='view_products.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
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
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-gradient-primary border-0 py-3">
                        <h2 class="text-center mb-0" style="color: #2c3e50; font-weight: 600;">Update Product</h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="Pname" class="form-control" id="productName" value="<?= $row['Pname'] ?>" required>
                                        <label for="productName">Product Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating">
                                        <input type="text" name="Pprice" class="form-control" id="productPrice" value="<?= $row['Pprice'] ?>" required>
                                        <label for="productPrice">Product Price</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold mb-2">Product Image</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1">
                                        <input type="file" name="Pimage" class="form-control" id="productImage">
                                    </div>
                                    <div class="current-image">
                                        <img src="<?= $row['Pimage'] ?>" class="rounded shadow-sm" height="90px" width="100px" alt="Current Image">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <select class="form-select" name="Pages" id="productCategory">
                                        <option value="Medecine" <?= $row['Pcategory'] == 'Medecine' ? 'selected' : '' ?>>Medicine</option>
                                        <option value="Syrup" <?= $row['Pcategory'] == 'Syrup' ? 'selected' : '' ?>>Syrup</option>
                                        <option value="Equipment" <?= $row['Pcategory'] == 'Equipment' ? 'selected' : '' ?>>Equipment</option>
                                    </select>
                                    <label for="productCategory">Select Page Category</label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="view_products.php" class="btn btn-secondary px-4">Cancel</a>
                                <button name="update" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Update Product
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
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
        }
        .card-header h2 {
            color: white !important;
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
        .current-image img {
            border: 2px solid #dce4ec;
            padding: 3px;
            background: white;
        }
    </style>
</body>
</html>
