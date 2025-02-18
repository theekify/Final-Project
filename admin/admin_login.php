<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the admin exists and is approved
    $sql = "SELECT * FROM admin WHERE Admin_Email = ? AND Admin_Status = 'Active'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['Admin_Password'])) {
        $_SESSION['admin_id'] = $admin['Admin_ID'];
        $_SESSION['admin_name'] = $admin['Admin_Name'];
        echo "<script>alert('Login successful!'); window.location.href='admin_dashboard.php';</script>";
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
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="admin_register.php">New Admin? Register</a>
</body>
</html>
