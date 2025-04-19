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
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
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
        font-weight: 600;
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
    textarea.form-control {
        min-height: 120px;
    }
</style>
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
                    <h2 class="text-center mb-0">Add New Product</h2>
                </div>
                <div class="card-body p-4">
                    <form action="insert.php" method="post" enctype="multipart/form-data" id="productForm">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="Pname" class="form-control" id="productName" placeholder="Enter Product Name" required>
                                    <label for="productName">Product Name</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="Pprice" class="form-control" id="productPrice" placeholder="Enter Product Price" required>
                                    <label for="productPrice">Product Price</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-2">Product Image</label>
                            <div class="input-group">
                                <input type="file" name="Pimage" class="form-control" id="productImage" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <select class="form-select" name="Pages" id="productCategory" required>
                                    <option value="Medecine">Medicine</option>
                                    <option value="Syrup">Syrup</option>
                                    <option value="Equipment">Equipment</option>
                                </select>
                                <label for="productCategory">Select Page Category</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea name="Pdescription" class="form-control" id="productDescription" style="height: 120px" placeholder="Enter Product Description" required></textarea>
                                <label for="productDescription">Product Description</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="view_products.php" class="btn btn-secondary px-4">
                                <i class="fas fa-eye me-2"></i>View Products
                            </a>
                            <button type="submit" name="submit" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 