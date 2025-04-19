<?php
// Database configuration for InfinityFree
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';  // Your vPanel password
$db_name = 'medical_store';

// Create connection with error handling
$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($con, "utf8");
?>