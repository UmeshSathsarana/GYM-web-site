<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "umesh";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Start session to manage admin login state
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email and password entered by the admin
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute a statement to get the stored password for the admin
    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($admin_id);
        $stmt->fetch();

        // Store admin session ID
        $_SESSION['admin_id'] = $admin_id;
        // Redirect to the admin dashboard
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo 'Invalid email or password';
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin-login-styles.css">
</head>
<body>
    <h2>Admin Login</h2>
    <form action="admin_login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>
