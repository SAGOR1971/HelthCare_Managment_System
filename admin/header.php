<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-light bg-primary">
    <div class="container-fluid text-white">
        <a href="mystore.php" class="navbar-brand text-white">
            <h1>Medical Store</h1>
        </a>
        <span>
            <i class="fa-solid fa-user-tie"></i> Hello, <?php echo $_SESSION['admin']; ?> |
            <i class="fa-solid fa-right-from-bracket"></i>
            <a href="form/logout.php" class="text-decoration-none text-white">Logout</a> |
            <a href="../user/index.php" class="text-decoration-none text-white">Users Panel</a>
        </span>
    </div>
</nav>
</body>
</html>