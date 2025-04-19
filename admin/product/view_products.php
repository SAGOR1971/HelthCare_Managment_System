<?php
include '../../connect/config.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("location:../form/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-gradient-primary border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">Home Page Products</h2>
                <a href="add_product.php" class="btn btn-light">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <?php
            $Record = mysqli_query($con, "SELECT p1.*, p2.Pcategory as original_category 
                                        FROM `tblproduct` p1 
                                        LEFT JOIN `tblproduct` p2 ON p1.Pname = p2.Pname 
                                        WHERE p1.Pcategory = 'Home' 
                                        AND p2.Pcategory != 'Home'");
            if (mysqli_num_rows($Record) > 0) {
                echo '
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>';
                        $no = 1;
                        while ($row = mysqli_fetch_array($Record)) {
                            echo "
                                <tr>
                                    <td class='px-4 py-3'>$no</td>
                                    <td class='px-4 py-3'>$row[Pname]</td>
                                    <td class='px-4 py-3'>$row[Pprice] Taka</td>
                                    <td class='px-4 py-3'>
                                        <img src='$row[Pimage]' class='product-img' alt='$row[Pname]'>
                                    </td>
                                    <td class='px-4 py-3'>
                                        <span class='badge bg-info px-3 py-2'>$row[original_category]</span>
                                    </td>
                                    <td class='px-4 py-3'>
                                        <div class='d-flex gap-2'>
                                            <a href='update.php?id=$row[Id]' class='btn btn-warning btn-sm'>
                                                <i class='fas fa-edit me-1'></i> Edit
                                            </a>
                                            <a href='delete.php?id=$row[Id]' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\")'>
                                                <i class='fas fa-trash me-1'></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            ";
                            $no++;
                        }
                        echo '</tbody></table>
                    </div>';
            } else {
                echo "
                    <div class='text-center py-5'>
                        <div class='mb-4'>
                            <i class='fas fa-box-open text-secondary' style='font-size: 4rem;'></i>
                        </div>
                        <h3 class='text-secondary mb-3'>No Products Found</h3>
                        <p class='text-muted mb-4'>It seems there are no products available at the moment.</p>
                        <a href='add_product.php' class='btn btn-primary px-4'>
                            <i class='fas fa-plus me-2'></i>Add New Product
                        </a>
                    </div>
                ";
            }
            ?>
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
    .table {
        margin-bottom: 0;
    }
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .product-img {
        height: 70px;
        width: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #eee;
        padding: 3px;
        background: white;
        transition: all 0.3s ease;
    }
    .product-img:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
    .btn-warning {
        background: #ffc107;
        border: none;
        color: #000;
    }
    .btn-danger {
        background: #dc3545;
        border: none;
    }
    .btn-primary {
        background: linear-gradient(135deg, #6B8DD6 0%, #8E37D7 100%);
        border: none;
    }
    .btn-light {
        background: rgba(255,255,255,0.9);
        border: none;
        font-weight: 500;
    }
    .btn-light:hover {
        background: #fff;
    }
    .table-responsive {
        border-radius: 0 0 8px 8px;
    }
    tbody tr {
        transition: all 0.3s ease;
    }
    tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 