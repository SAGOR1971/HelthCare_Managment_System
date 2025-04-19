<?php
session_start();
include('../connect/config.php');
// Check if admin is logged in
if(!isset($_SESSION['admin'])) {
    echo "<script>
        alert('Please login first!');
        window.location.href='form/login.php';
    </script>";
    exit();
}

// Handle message deletion
if(isset($_POST['delete_message'])) {
    $message_id = mysqli_real_escape_string($con, $_POST['message_id']);
    $delete_query = "DELETE FROM contact_messages WHERE id = '$message_id'";
    if(mysqli_query($con, $delete_query)) {
        echo "<script>alert('Message deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting message: " . mysqli_error($con) . "');</script>";
    }
}

// Fetch all messages
$messages_query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$messages_result = mysqli_query($con, $messages_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact Messages</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .message-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .message-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .message-sender {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .message-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .message-content {
            color: #2c3e50;
            line-height: 1.6;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, var(--accent-color), #c0392b);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--secondary-color);
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--secondary-color);
            border-radius: 3px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container py-5">
        <h2 class="section-title">Contact Messages</h2>
        
        <?php if(mysqli_num_rows($messages_result) > 0): ?>
            <div class="row">
                <?php while($message = mysqli_fetch_assoc($messages_result)): ?>
                    <div class="col-md-6 mb-4">
                        <div class="message-card">
                            <div class="message-header">
                                <div>
                                    <h5 class="message-sender mb-0">
                                        <i class="fas fa-user me-2"></i><?php echo htmlspecialchars($message['name']); ?>
                                    </h5>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($message['email']); ?>
                                    </small>
                                </div>
                                <div class="message-date">
                                    <i class="far fa-clock me-1"></i>
                                    <?php echo date('d M Y, h:i A', strtotime($message['created_at'])); ?>
                                </div>
                            </div>
                            <div class="message-content">
                                <?php echo nl2br(htmlspecialchars($message['message'])); ?>
                            </div>
                            <div class="mt-3">
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="d-inline">
                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                    <button type="submit" name="delete_message" class="btn btn-danger">
                                        <i class="fas fa-trash-alt me-2"></i>Delete Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body empty-state">
                    <i class="fas fa-inbox"></i>
                    <h4>No Messages</h4>
                    <p>There are no contact messages at the moment.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 