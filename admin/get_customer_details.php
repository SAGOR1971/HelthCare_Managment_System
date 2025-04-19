<?php
session_start();
if(!isset($_SESSION['admin'])){
    header('HTTP/1.0 403 Forbidden');
    echo json_encode(['error' => 'Unauthorized access']);
    exit();
}

include('../connect/config.php');

if (!isset($_GET['user_id'])) {
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(['error' => 'User ID is required']);
    exit();
}

$user_id = intval($_GET['user_id']);

try {
    // Get customer basic info and statistics
    $query = "SELECT 
        u.*,
        COUNT(DISTINCT o.order_id) as total_orders,
        COUNT(DISTINCT a.id) as total_appointments,
        COALESCE(SUM(o.total_amount), 0) + COALESCE(SUM(a.amount_paid), 0) as total_spent
    FROM tbluser u
    LEFT JOIN tblorders o ON u.Id = o.user_id
    LEFT JOIN tblappointments a ON u.Id = a.user_id
    WHERE u.Id = ?
    GROUP BY u.Id";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $customer = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Get orders history
    $query = "SELECT * FROM tblorders WHERE user_id = ? ORDER BY order_date DESC";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $orders = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

    // Get appointments history
    $query = "SELECT 
        a.*,
        d.name as doctor_name,
        d.specialty
    FROM tblappointments a
    JOIN doctors d ON a.doctor_id = d.id
    WHERE a.user_id = ?
    ORDER BY a.appointment_date DESC, a.time_slot";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $appointments = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

    // Calculate points statistics
    $points_query = "SELECT 
        COALESCE(SUM(reward_points_earned), 0) as total_earned,
        COALESCE(SUM(reward_points_used), 0) as total_used
    FROM tblorders
    WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $points_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $points_stats = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    // Prepare response
    $response = [
        'customer' => [
            'username' => $customer['username'],
            'Email' => $customer['Email'],
            'Number' => $customer['Number'],
            'total_orders' => $customer['total_orders'],
            'total_appointments' => $customer['total_appointments'],
            'total_spent' => number_format($customer['total_spent'], 2),
            'reward_points' => number_format($customer['reward_points'], 2)
        ],
        'orders' => array_map(function($order) {
            $order['total_amount'] = number_format($order['total_amount'], 2);
            $order['reward_points_used'] = number_format($order['reward_points_used'], 2);
            $order['reward_points_earned'] = number_format($order['reward_points_earned'], 2);
            return $order;
        }, $orders),
        'appointments' => array_map(function($apt) {
            $apt['amount_paid'] = number_format($apt['amount_paid'], 2);
            return $apt;
        }, $appointments),
        'points' => [
            'current' => number_format($customer['reward_points'], 2),
            'earned' => number_format($points_stats['total_earned'], 2),
            'used' => number_format($points_stats['total_used'], 2)
        ]
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo json_encode(['error' => 'Failed to fetch customer details']);
} 