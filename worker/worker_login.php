<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if worker exists and is approved
    $sql = "SELECT * FROM worker WHERE Worker_Email = ? AND Worker_Status = 'Approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $worker = $result->fetch_assoc();

    if ($worker && password_verify($password, $worker['Worker_Password'])) {
        $_SESSION['worker_id'] = $worker['Worker_ID'];
        $_SESSION['worker_name'] = $worker['Worker_Name'];
        echo "<script>alert('Login successful!'); window.location.href='worker_dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid credentials or account not approved.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Login</title>
</head>
<body>
    <h2>Worker Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="worker_register.php">New Worker? Register</a>
</body>
</html>
