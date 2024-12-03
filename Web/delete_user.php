<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "umesh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect to admin dashboard with success message
        header("Location: admin_dashboard.php?message=User deleted successfully");
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "User ID not provided.";
}

// Close connection
$conn->close();
?>
