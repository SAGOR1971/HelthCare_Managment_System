<?php
include('../../connect/config.php');
if(isset($_POST['submit'])){
    $Name = $_POST['name'];
    $Email = $_POST['email'];
    $Number = $_POST['phone'];
    $Password = $_POST['password'];
    
    $Dup_Email = mysqli_query($con,"SELECT * FROM `tbluser` WHERE Email='$Email'");
    $Dup_UserName = mysqli_query($con,"SELECT * FROM `tbluser` WHERE username='$Name'");
    
    if(mysqli_num_rows($Dup_Email)){
        echo"
        <script>
        alert('This Email is already Taken');
        window.location.href = 'register.php';
        </script>
        ";
    }
    if(mysqli_num_rows($Dup_UserName)){
        echo"
        <script>
        alert('This Email is already Taken');
        window.location.href = 'register.php';
        </script>
        "; 
    }
    else{
        mysqli_query($con,"INSERT INTO `tbluser`(`username`, `Email`, `Number`, `Password`) VALUES ('$Name','$Email','$Number','$Password')");
        echo"
        <script>
        alert('Register Successful');
        window.location.href = 'login.php';
        </script>
        "; 
    }
}
?>
