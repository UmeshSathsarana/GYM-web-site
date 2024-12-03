<?php
session_start();
include 'db_connect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all users
$user_sql = "SELECT id, full_name, email, age FROM users";
$user_result = $conn->query($user_sql);

// Fetch all contact messages
$message_sql = "SELECT id, name, email, phone, subject, message, created_at FROM contact_messages";
$message_result = $conn->query($message_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin!</p>

    <!-- Registered Users Section -->
    <h3>Registered Users</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Actions</th>
        </tr>
        <?php while ($user_row = $user_result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $user_row['id']; ?></td>
                <td><?php echo $user_row['full_name']; ?></td>
                <td><?php echo $user_row['email']; ?></td>
                <td><?php echo $user_row['age']; ?></td>
                <td>
                    <a href="delete_user.php?id=<?php echo $user_row['id']; ?>" 
                       onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <!-- Contact Messages Section -->
    <h3>Contact Messages</h3>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Received At</th>
        <th>Actions</th>
    </tr>
    <?php while ($message_row = $message_result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $message_row['id']; ?></td>
            <td><?php echo $message_row['name']; ?></td>
            <td><?php echo $message_row['email']; ?></td>
            <td><?php echo $message_row['phone']; ?></td>
            <td><?php echo $message_row['subject']; ?></td>
            <td><?php echo $message_row['message']; ?></td>
            <td><?php echo $message_row['created_at']; ?></td>
            <td>
                <a href="delete_message.php?id=<?php echo $message_row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>


    <a href="logout.php">Logout</a>
</body>
</html>

<?php
$conn->close();
?>
