<?php
session_start();
include 'db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID to prevent SQL injection

    // Delete the message with the given ID
    $sql = "DELETE FROM contact_messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to the admin dashboard with a success message
        header("Location: admin_dashboard.php?message=Message deleted successfully!");
    } else {
        // Redirect with an error message
        header("Location: admin_dashboard.php?message=Error deleting the message.");
    }

    $stmt->close();
} else {
    // Redirect back if no ID is provided
    header("Location: admin_dashboard.php?message=No message ID provided.");
}

$conn->close();
?>
