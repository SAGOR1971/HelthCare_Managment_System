<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Equipment - Healthcare Store</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            padding: 60px 0;
            margin-bottom: 30px;
            color: white;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 15px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-3px);
        }

        .product-image {
            position: relative;
            padding-top: 75%;
            overflow: hidden;
        }

        .product-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-details {
            padding: 15px;
        }

        .product-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-color);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.4rem;
        }

        .product-price {
            font-size: 1.1rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 0.9rem;
        }

        .quantity-input {
            width: 60px;
            padding: 6px;
            border: 2px solid #ddd;
            border-radius: 6px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Quick Actions */
        .quick-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            transform: translateX(15px);
            transition: all 0.3s ease;
        }

        .product-card:hover .quick-actions {
            opacity: 1;
            transform: translateX(0);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Modal Styling */
        .product-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 700px;
            position: relative;
            padding: 0;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0;
            position: relative;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-image-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .modal-image {
            max-width: 200px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .modal-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .modal-price {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin: 10px 0;
            font-weight: 600;
        }

        .modal-description {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .product-info {
            margin: 15px 0;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .product-info p {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-info i {
            color: var(--primary-color);
            width: 16px;
        }

        .product-info p:last-child {
            margin-bottom: 0;
        }

        /* No Products Styling */
        .no-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.05);
            margin: 20px 0;
        }

        .no-products-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .no-products h2 {
            font-size: 1.8rem;
            color: var(--text-color);
            margin-bottom: 12px;
            font-weight: 600;
        }

        .no-products p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 20px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
                padding: 10px;
            }

            .product-details {
                padding: 12px;
            }

            .product-title {
                font-size: 0.9rem;
                height: 2.2rem;
            }

            .product-price {
                font-size: 1rem;
                margin-bottom: 10px;
            }

            .btn-primary {
                padding: 6px 12px;
                font-size: 0.85rem;
            }

            .quantity-input {
                width: 50px;
                padding: 5px;
                font-size: 0.85rem;
            }

            .action-btn {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }

            .modal-content {
                width: 95%;
                margin: 10px;
            }
            
            .modal-body {
                padding: 15px;
            }

            .modal-image {
                max-width: 150px;
            }

            .modal-title {
                font-size: 1.2rem;
            }

            .modal-price {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Medical Equipment</h1>
            <p>Browse our wide selection of quality medical equipment</p>
        </div>
    </div>

    <div class="container">
        <div class="product-grid">
            <?php
            $Record = mysqli_query($con, "SELECT * FROM `tblproduct`");
            $hasProducts = false;
            while ($row = mysqli_fetch_array($Record)) {
                $check_page = $row['Pcategory'];
                if ($check_page === 'Equipment') {
                    $hasProducts = true;
                    echo "
                    <form action='insert_cart.php' method='post'>
                        <div class='product-card'>
                            <div class='product-image' onclick='showProductDetails(\"$row[Pname]\", \"$row[Pprice]\", \"$row[Pimage]\", \"$row[Pdescription]\")'>
                                <img src='../admin/product/$row[Pimage]' alt='$row[Pname]'>
                            </div>
                            <div class='quick-actions'>
                                <div class='action-btn' onclick='showProductDetails(\"$row[Pname]\", \"$row[Pprice]\", \"$row[Pimage]\", \"$row[Pdescription]\")'>
                                    <i class='fas fa-eye'></i>
                                </div>
                                <div class='action-btn'>
                                    <i class='fas fa-heart'></i>
                                </div>
                            </div>
                            <div class='product-details'>
                                <h3 class='product-title'>$row[Pname]</h3>
                                <div class='product-price'>৳$row[Pprice]</div>
                                <div class='product-actions'>
                                    <input type='hidden' name='Pname' value='$row[Pname]'>
                                    <input type='hidden' name='Pprice' value='$row[Pprice]'>
                                    <input type='number' name='Pquantity' min='1' max='20' value='1' class='quantity-input' onclick='stopPopup(event)'>
                                    <button type='submit' name='addcart' class='btn btn-primary' onclick='stopPopup(event)'>
                                        <i class='fas fa-shopping-cart'></i> Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    ";
                }
            }
            if (!$hasProducts) {
                echo "
                <div class='no-products'>
                    <div class='no-products-icon'>
                        <i class='fas fa-stethoscope'></i>
                    </div>
                    <h2>No Equipment Available</h2>
                    <p>We're currently updating our medical equipment inventory. Please check back later.</p>
                </div>";
            }
            ?>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="product-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close-modal" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="modal-image-container">
                            <img id="modalImage" class="modal-image" src="" alt="">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="modal-price" id="modalPrice"></div>
                        <div class="product-info">
                            <p><i class="fas fa-box"></i> <span>Category: Medical Equipment</span></p>
                            <p><i class="fas fa-check-circle"></i> <span>In Stock</span></p>
                            <p><i class="fas fa-shipping-fast"></i> <span>Fast Delivery Available</span></p>
                        </div>
                        <div class="modal-description">
                            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Product Description</h5>
                            <p id="modalDescription"></p>
                        </div>
                        <form action="insert_cart.php" method="post" class="mt-4">
                            <input type="hidden" id="modalProductName" name="Pname" value="">
                            <input type="hidden" id="modalProductPrice" name="Pprice" value="">
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-floating" style="width: 100px;">
                                    <input type="number" class="form-control" id="quantity" name="Pquantity" min="1" max="20" value="1">
                                    <label for="quantity">Quantity</label>
                                </div>
                                <button type="submit" name="addcart" class="btn btn-primary">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showProductDetails(name, price, image, description) {
            document.getElementById("modalTitle").innerText = name;
            document.getElementById("modalPrice").innerText = "৳" + price;
            document.getElementById("modalImage").src = "../admin/product/" + image;
            document.getElementById("modalDescription").innerText = description;
            document.getElementById("modalProductName").value = name;
            document.getElementById("modalProductPrice").value = price;
            document.getElementById("productModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("productModal").style.display = "none";
        }

        function stopPopup(event) {
            event.stopPropagation();
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById("productModal")) {
                closeModal();
            }
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
