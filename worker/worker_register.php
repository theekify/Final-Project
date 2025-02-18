<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Insert worker into user table with 'Pending' status
    $sql = "INSERT INTO user (User_Name, User_Email, User_Password, User_Phone, User_Address, User_Role, User_Status)
            VALUES (?, ?, ?, ?, ?, 'Worker', 'Pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Wait for approval.'); window.location.href='worker_login.php';</script>";
    } else {
        echo "<script>alert('Error registering worker.'); window.history.back();</script>";
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
    <title>Worker Registration</title>
</head>
<body>
    <h2>Worker Registration</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone Number"><br>
        <input type="text" name="address" placeholder="Address"><br>
        <button type="submit">Register</button>
    </form>
    <a href="worker_login.php">Already have an account? Login</a>
</body>
</html>
