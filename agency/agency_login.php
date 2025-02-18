<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if agency exists and is approved
    $sql = "SELECT * FROM agency WHERE Agency_Email = ? AND Agency_Status = 'Approved'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $agency = $result->fetch_assoc();

    if ($agency && password_verify($password, $agency['Agency_Password'])) {
        $_SESSION['agency_id'] = $agency['Agency_ID'];
        $_SESSION['agency_name'] = $agency['Agency_Name'];
        echo "<script>alert('Login successful!'); window.location.href='agency_dashboard.php';</script>";
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
    <title>Agency Login</title>
</head>
<body>
    <h2>Agency Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <a href="agency_register.php">New Agency? Register</a>
</body>
</html>
