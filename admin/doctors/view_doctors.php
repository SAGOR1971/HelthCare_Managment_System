<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Doctors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <?php
    session_start();
    if(!$_SESSION['admin']){
        header("location:../form/login.php");
    }
    include('../../connect/config.php');
    ?>
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
                    <h2 class="text-white mb-0">Manage Doctors</h2>
                    <a href="add_doctors.php" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i>Add New Doctor
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <?php
                $select_query = "SELECT * FROM doctors ORDER BY id DESC";
                $result = mysqli_query($con, $select_query);
                
                if(mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Number</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Specialty</th>
                                <th class="px-4 py-3">Hospital</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td class='px-4 py-3'>$no</td>
                                    <td class='px-4 py-3'>{$row['name']}</td>
                                    <td class='px-4 py-3'>{$row['number']}</td>
                                    <td class='px-4 py-3'>{$row['email']}</td>
                                    <td class='px-4 py-3'>
                                        <span class='badge bg-info px-3 py-2'>{$row['specialty']}</span>
                                    </td>
                                    <td class='px-4 py-3'>{$row['hospital']}</td>
                                    <td class='px-4 py-3'>
                                        <div class='d-flex gap-2'>
                                            <a href='update_doctor.php?id={$row['id']}' class='btn btn-warning btn-sm'>
                                                <i class='fas fa-edit me-1'></i> Edit
                                            </a>
                                            <a href='delete_doctor.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this doctor?\");'>
                                                <i class='fas fa-trash me-1'></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                } else {
                ?>
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-user-md text-secondary" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-secondary mb-3">No Doctors Available</h3>
                    <p class="text-muted mb-4">There are currently no doctors in the system. Start by adding a new doctor.</p>
                    <a href="add_doctors.php" class="btn btn-primary px-4">
                        <i class="fas fa-plus me-2"></i>Add First Doctor
                    </a>
                </div>
                <?php
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