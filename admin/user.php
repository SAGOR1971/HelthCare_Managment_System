<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("location:form/login.php");
    exit();
}
include('../connect/config.php');
$query = "SELECT 
    u.*,
    COUNT(DISTINCT o.order_id) as total_orders,
    COUNT(DISTINCT a.id) as total_appointments,
    COALESCE(SUM(o.total_amount), 0) as total_order_amount,
    COALESCE(SUM(a.amount_paid), 0) as total_appointment_amount,
    (SELECT COUNT(*) FROM tblorders WHERE user_id = u.Id AND payment_status = 'completed') as completed_orders,
    (SELECT COUNT(*) FROM tblappointments WHERE user_id = u.Id AND status = 'Completed') as completed_appointments,
    (SELECT COUNT(*) FROM tblappointments WHERE user_id = u.Id AND status = 'Cancelled') as cancelled_appointments
FROM tbluser u
LEFT JOIN tblorders o ON u.Id = o.user_id
LEFT JOIN tblappointments a ON u.Id = a.user_id
GROUP BY u.Id";

$Record = mysqli_query($con, $query);
$row_count = mysqli_num_rows($Record);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reports</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .stats-card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .table th {
            background-color: #0d6efd;
            color: white;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Customer Reports</h2>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                                <th>ID</th>
                                <th>Customer Details</th>
                                <th>Orders</th>
                                <th>Appointments</th>
                                <th>Financial Summary</th>
                                <th>Reward Points</th>
                                <th>Actions</th>
                        </tr>
                    </thead>

                        <tbody>
                        <?php
                        $no=1;
                        while ($row = mysqli_fetch_array($Record)) {
                                $total_spent = $row['total_order_amount'] + $row['total_appointment_amount'];
                            echo "
                                <tr>
                                        <td class='text-center'>$no</td>
                                        <td>
                                            <strong>{$row['username']}</strong><br>
                                            <i class='fas fa-envelope'></i> {$row['Email']}<br>
                                            <i class='fas fa-phone'></i> {$row['Number']}
                                        </td>
                                        <td class='text-center'>
                                            <div class='stats-card bg-light p-2'>
                                                <h5>{$row['total_orders']}</h5>
                                                <small class='text-muted'>Total Orders</small><br>
                                                <span class='badge bg-success'>{$row['completed_orders']} Completed</span>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <div class='stats-card bg-light p-2'>
                                                <h5>{$row['total_appointments']}</h5>
                                                <small class='text-muted'>Total Appointments</small><br>
                                                <span class='badge bg-success'>{$row['completed_appointments']} Completed</span>
                                                <span class='badge bg-danger'>{$row['cancelled_appointments']} Cancelled</span>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <div class='stats-card bg-light p-2'>
                                                <h5>" . number_format($total_spent, 2) . " Taka</h5>
                                                <small class='text-muted'>Total Spent</small><br>
                                                <small>Orders: " . number_format($row['total_order_amount'], 2) . " Taka</small><br>
                                                <small>Appointments: " . number_format($row['total_appointment_amount'], 2) . " Taka</small>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <div class='stats-card bg-light p-2'>
                                                <h5>" . number_format($row['reward_points'], 2) . "</h5>
                                                <small class='text-muted'>Available Points</small>
                                            </div>
                                        </td>
                                        <td class='text-center'>
                                            <button class='btn btn-info btn-sm mb-2' onclick='viewDetails({$row['Id']})'>
                                                <i class='fas fa-eye'></i> View Details
                                            </button><br>
                                            <a href='delete.php?ID={$row['Id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>
                                                <i class='fas fa-trash'></i> Delete
                                            </a>
                                        </td>
                                </tr>
                            ";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        
        <!-- Summary Cards -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Customers</h5>
                        <h2><?php echo $row_count; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <h2><?php 
                            $total_orders = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as count FROM tblorders"))[0];
                            echo $total_orders;
                        ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Appointments</h5>
                        <h2><?php 
                            $total_appointments = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as count FROM tblappointments"))[0];
                            echo $total_appointments;
                        ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <h2><?php 
                            $total_revenue = mysqli_fetch_array(mysqli_query($con, 
                                "SELECT COALESCE(SUM(total_amount), 0) + COALESCE((SELECT SUM(amount_paid) FROM tblappointments), 0) as total 
                                FROM tblorders"))[0];
                            echo number_format($total_revenue, 2);
                        ?> TaKa</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Details Modal -->
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="customerInfo" class="mb-4">
                        <!-- Customer basic info will be loaded here -->
                    </div>
                    
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="detailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">Orders History</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appointments-tab" data-bs-toggle="tab" data-bs-target="#appointments" type="button" role="tab">Appointments History</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="points-tab" data-bs-toggle="tab" data-bs-target="#points" type="button" role="tab">Reward Points History</button>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content p-3 border border-top-0">
                        <div class="tab-pane fade show active" id="orders" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped" id="ordersTable">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Payment Method</th>
                                            <th>Status</th>
                                            <th>Points Used</th>
                                            <th>Points Earned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Orders will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="appointments" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped" id="appointmentsTable">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Appointments will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="points" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Current Points Balance</h5>
                                            <h3 id="currentPoints">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Points Earned</h5>
                                            <h3 id="totalPointsEarned">0</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Points Used</h5>
                                            <h3 id="totalPointsUsed">0</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function viewDetails(userId) {
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('customerDetailsModal'));
            modal.show();

            // Fetch customer details
            fetch(`get_customer_details.php?user_id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    // Update customer info
                    document.getElementById('customerInfo').innerHTML = `
                        <div class="row">
                            <div class="col-md-4">
                                <h4>${data.customer.username}</h4>
                                <p><i class="fas fa-envelope"></i> ${data.customer.Email}</p>
                                <p><i class="fas fa-phone"></i> ${data.customer.Number}</p>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="small-stats">
                                            <h6>Total Orders</h6>
                                            <h4>${data.customer.total_orders}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="small-stats">
                                            <h6>Total Appointments</h6>
                                            <h4>${data.customer.total_appointments}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="small-stats">
                                            <h6>Total Spent</h6>
                                            <h4>${data.customer.total_spent} Taka</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="small-stats">
                                            <h6>Reward Points</h6>
                                            <h4>${data.customer.reward_points}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    // Update orders table
                    const ordersTableBody = document.querySelector('#ordersTable tbody');
                    ordersTableBody.innerHTML = data.orders.map(order => `
                        <tr>
                            <td>${order.order_id}</td>
                            <td>${order.order_date}</td>
                            <td>${order.total_amount} Taka</td>
                            <td>${order.payment_method}</td>
                            <td><span class="badge bg-${order.payment_status === 'completed' ? 'success' : 'warning'}">${order.payment_status}</span></td>
                            <td>${order.reward_points_used}</td>
                            <td>${order.reward_points_earned}</td>
                        </tr>
                    `).join('');

                    // Update appointments table
                    const appointmentsTableBody = document.querySelector('#appointmentsTable tbody');
                    appointmentsTableBody.innerHTML = data.appointments.map(apt => `
                        <tr>
                            <td>${apt.appointment_date}</td>
                            <td>${apt.time_slot}</td>
                            <td>Dr. ${apt.doctor_name}</td>
                            <td>${apt.amount_paid} Taka</td>
                            <td><span class="badge bg-${getStatusColor(apt.status)}">${apt.status}</span></td>
                        </tr>
                    `).join('');

                    // Update points summary
                    document.getElementById('currentPoints').textContent = data.points.current;
                    document.getElementById('totalPointsEarned').textContent = data.points.earned;
                    document.getElementById('totalPointsUsed').textContent = data.points.used;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading customer details');
                });
        }

        function getStatusColor(status) {
            switch(status.toLowerCase()) {
                case 'completed': return 'success';
                case 'cancelled': return 'danger';
                case 'confirmed': return 'primary';
                default: return 'warning';
            }
        }
    </script>
</body>
</html>
