<?php
include 'db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $plan = $_POST['plan'];
    $amount = $_POST['amount'];
    $card_number = substr($_POST['card_number'], -4); // Only store last 4 digits for security

    // Generate a transaction ID
    $transaction_id = uniqid('txn_');

    // Insert payment record
    $sql = "INSERT INTO payments (user_id, plan, amount, card_number, transaction_id, payment_status) VALUES (?, ?, ?, ?, ?, 'completed')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdss", $user_id, $plan, $amount, $card_number, $transaction_id);

    if ($stmt->execute()) {
        echo "
        <style>
            .payment-success {
                font-family: Arial, sans-serif;
                color: #155724;
                background-color: #d4edda;
                border: 1px solid #c3e6cb;
                padding: 20px;
                border-radius: 8px;
                width: 80%;
                margin: 20px auto;
                text-align: center;
            }
            .payment-success h2 {
                color: #155724;
            }
            .payment-success a {
                color: #0b3d91;
                text-decoration: none;
                font-weight: bold;
            }
            .payment-success a:hover {
                text-decoration: underline;
            }
        </style>
        <div class='payment-success'>
            <h2>Thank you! Your payment was successful.</h2>
            <p>Your membership for the plan is now active.</p>
            <p>Transaction ID: <strong>$transaction_id</strong></p>
            <a href='membership.html'>Return to Membership Page</a>
        </div>";
    } else {
        echo "
        <style>
            .payment-error {
                font-family: Arial, sans-serif;
                color: #721c24;
                background-color: #f8d7da;
                border: 1px solid #f5c6cb;
                padding: 20px;
                border-radius: 8px;
                width: 80%;
                margin: 20px auto;
                text-align: center;
            }
        </style>
        <div class='payment-error'>
            <h2>Error processing payment</h2>
            <p>" . htmlspecialchars($stmt->error) . "</p>
        </div>";
    }

    $stmt->close();
}
$conn->close();
?>
