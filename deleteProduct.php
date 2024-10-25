<?php
// Database configuration
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'capstoneloginver2'; 

// Create a connection
$db = new mysqli($host, $username, $password, $database);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
        
        // Prepare and execute the delete statement
        $deleteQuery = "DELETE FROM products WHERE id=?";
        $deleteStmt = $db->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
        
        if ($deleteStmt->execute()) {
            echo "Product deleted successfully!";
        } else {
            echo "Error deleting product: " . $deleteStmt->error;
        }
        
        $deleteStmt->close();
        
        // Redirect back to products page
        header('Location: myProducts.php');
        exit;
    } else {
        echo "Invalid product ID.";
    }
}

// Close the database connection
$db->close();
?>
