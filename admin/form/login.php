<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- BootStrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- FontAwsome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .btn-link {
            text-decoration: none;
            color: white;
        }
        .btn-link:hover {
            color: white;
            opacity: 0.9;
        }
    </style>
</head>
<body class="bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col-md-6 shadow bg-white font-monospace p-3 m-auto border border-primary mt-3">
                <form action="login1.php" method="post">
                    <div class="mb-3">
                        <p class="text-center fw-bold fs-3 text-warning">Admin Login</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter User Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="userpassword" class="form-control" placeholder="Enter Password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-danger w-100 fs-4 text-white">Login</button>
                    </div>
                </form>
                <div class="mb-3">
                    <a href="../../index.php" class="btn btn-info w-100 fs-4 text-white text-decoration-none">
                        <i class="fas fa-home"></i> Go Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>