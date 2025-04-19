<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome CDN -->
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

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 m-auto bg-white shadow font-monospace border border-info">
                <p class="text-warning text-center fs-3 fw-bold my-3">User Register</p>
                <form action="insert.php" method="POST">
                    <div class="mb-3">
                        <label for=""> User Name:</label>
                        <input type="text" name="name" placeholder="Enter User Name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for=""> Email:</label>
                        <input type="email" name="email" placeholder="Enter Email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for=""> Phone:</label>
                        <input type="number" name="phone" placeholder="Enter Phone Number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for=""> Password:</label>
                        <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-warning w-100 fs-4 text-white">Register</button>
                    </div>
                </form>
                <div class="mb-3">
                    <a href="login.php" class="btn btn-danger w-100 fs-4 text-white text-decoration-none">Already Have an Account?</a>
                </div>
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