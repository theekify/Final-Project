<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];

    // Insert admin into user table with 'Pending' status
    $sql = "INSERT INTO user (User_Name, User_Email, User_Password, User_Phone, User_Role, User_Status)
            VALUES (?, ?, ?, ?, 'Admin', 'Pending')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $phone);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Wait for approval.'); window.location.href='admin_login.php';</script>";
    } else {
        echo "<script>alert('Error registering admin.'); window.history.back();</script>";
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
    <title>Admin Registration</title>
</head>
<body>
    <h2>Admin Registration</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="phone" placeholder="Phone Number"><br>
        <button type="submit">Register</button>
    </form>
    <a href="admin_login.php">Already have an account? Login</a>
</body>
</html>
