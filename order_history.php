<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch the user's order history from the database
$userId = $_SESSION['user_id'];
$query = "
    SELECT o.id, p.name AS product_name, p.price AS product_price, p.image_url AS product_image, o.order_date, o.status
    FROM orders o
    JOIN products p ON o.product_id = p.id
    WHERE o.user_id = ?
    ORDER BY o.order_date DESC
";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">

    <div class="container mx-auto">
        <h2 class="text-3xl font-bold mb-4">Your Order History</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border-b">Order ID</th>
                        <th class="px-4 py-2 border-b">Product Image</th>
                        <th class="px-4 py-2 border-b">Product Name</th>
                        <th class="px-4 py-2 border-b">Price</th>
                        <th class="px-4 py-2 border-b">Order Date</th>
                        <th class="px-4 py-2 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) { ?>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                                <td class="px-4 py-2 border-b">
                                    <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="w-16 h-16 object-cover">
                                </td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['product_price']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['order_date']); ?></td>
                                <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="px-4 py-2 border-b text-center">No orders found.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php $stmt->close(); $db->close(); ?>
</body>
</html>