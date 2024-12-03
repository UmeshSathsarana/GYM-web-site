<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $age = $_POST['Age'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (full_name, email, age, password) VALUES ('$full_name', '$email', '$age', '$password')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id; // Get the ID of the newly created user

        // Insert initial payment record with status "pending"
        $plan = $_GET['plan'] ?? 'basic'; // Get the plan from the URL or default to basic
        $payment_sql = "INSERT INTO payments (user_id, plan, payment_status) VALUES ($user_id, '$plan', 'pending')";
        $conn->query($payment_sql);

        // Redirect to payment page with the selected plan
        header("Location: payment.html?plan=" . urlencode($plan));
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

?>
