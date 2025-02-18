<?php
$host = "localhost"; // Change if needed
$user = "root"; // Change if needed
$password = "orypubit"; // Change if needed
$database = "JobPortal"; // Your database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
