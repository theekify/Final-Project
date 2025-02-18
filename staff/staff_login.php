<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if staff exists and is approved
    $sql = "SELECT * FROM staff WHERE Staff_Email = ? AND Staff_Status = 'Approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();

    if ($staff && password_verify($password, $staff['Staff_Password'])) {
        $_SESSION['staff_id'] = $staff['Staff_ID'];
        $_SESSION['staff_name'] = $staff['Staff_Name'];
        echo "<script>alert('Login successful!'); window.location.href='staff_dashboard.php';</script>";
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
    <title>Staff Login</title>
</head>
<body>
    <h2>Staff Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="staff_register.php">New Staff? Register</a>
</body>
</html>
