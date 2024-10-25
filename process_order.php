<?php
// Start session
session_start();
include 'db_connection.php';

// Assuming you have the user ID stored in the session
$user_id = $_SESSION['user_id']; // Get the logged-in user ID
$product_id = $_POST['product_id']; // Get product ID from form submission
$status = "Pending"; // Set initial order status

// Insert order record
$stmt = $db->prepare("INSERT INTO orders (user_id, product_id, order_date, status) VALUES (?, ?, NOW(), ?)");
$stmt->bind_param("iis", $user_id, $product_id, $status);

if ($stmt->execute()) {
    echo "Order recorded successfully.";
} else {
    echo "Error: " . $stmt->error;
}
// Getting FB Acc through js
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the Facebook account from the form
    if (isset($_POST['facebook_account'])) {
        $_SESSION['facebook_account'] = htmlspecialchars($_POST['facebook_account']);
    }
    // Process the order...
}



// Close connections
$stmt->close();
$db->close();
?>
