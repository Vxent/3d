<?php
session_start();
include 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Check if the user is an admin (BACKUP)
// if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
//     echo "Access denied.";
//     exit();
// }
$query = "
    SELECT o.id, u.username, u.address, u.contact_no, p.name AS product_name, p.price AS product_price, p.image_url AS product_image, o.order_date, o.status 
    FROM orders o
    JOIN users u ON o.user_id = u.id
    JOIN products p ON o.product_id = p.id
    ORDER BY o.order_date DESC
";




$result = $db->query($query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kween P Sports</title>
    <!-- tailwind css cdn -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="images/headlogo.png"  type="image/x-icon">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Red+Hat+Display:wght@500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: orange; }
        .cta-btn { color: black; }
        .upgrade-btn { background: black; }
        .upgrade-btn:hover { background: black; }
        .active-nav-link { background: grey; }
        .nav-item:hover { background: grey; }
        .account-link:hover { background: grey; }
    </style>
<body class="bg-gray-100 font-family-karla flex">

    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
        <img src="images/logo1.png" alt="">
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="adminDashboard.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="userOrder.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
               User Orders
            </a>
            <a href="myProducts.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-table mr-3"></i>
                My Products
      
     
        </nav>

    </aside>

    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
                <a href="index.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="blank.html" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                    <i class="fas fa-sticky-note mr-3"></i>
                   User Orders
                </a>
                <a href="tables.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-table mr-3"></i>
                    Tables
                </a>
                <a href="forms.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-align-left mr-3"></i>
                    Forms
                </a>
                <a href="tabs.html" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-tablet-alt mr-3"></i>
                    Tabbed Content
                </a>
         
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-cogs mr-3"></i>
                    Support
                </a>
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-user mr-3"></i>
                    My Account
                </a>
                <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Sign Out
                </a>
                <button class="w-full bg-white cta-btn font-semibold py-2 mt-3 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                    <i class="fas fa-arrow-circle-up mr-3"></i> Upgrade to Pro!
                </button>
            </nav>
 
        </header>
    
        <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold mb-4">Order Details</h2>
    <div class="overflow-x-auto">
        <?php if ($result->num_rows > 0) { ?>
            <table class="min-w-full border border-gray-600">
                    <thead class="bg-gray-600 ">
                        <tr>
                            <th class="px-4 py-2 text-left border-b">Order ID</th>
                            <th class="px-4 py-2 text-left border-b">Customer</th>
                            <th class="px-4 py-2 text-left border-b">Address</th>
                            <th class="px-4 py-2 text-left border-b">Contact No</th>
                            <th class="px-4 py-2 text-left border-b">FB Account</th>
                            <th class="px-4 py-2 text-left border-b">Product Name</th>
                            <th class="px-4 py-2 text-left border-b">Product Price</th>
                            <th class="px-4 py-2 text-left border-b">Product Image</th>
                            <th class="px-4 py-2 text-left border-b">Order Date</th>
                            <th class="px-4 py-2 text-left border-b">Status</th>
                            <th class="px-4 py-2 text-left border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['username']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['address']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['contact_no']); ?></td>
                            <td id="facebookAccountCell" class="px-4 py-2 border-b"><?php echo isset($_SESSION['facebook_account']) ? htmlspecialchars($_SESSION['facebook_account']) : 'N/A'; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['product_price']); ?></td>
                            <td class="px-4 py-2 border-b">
                                <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="w-16 h-16">
                            </td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['order_date']); ?></td>
                            <td class="px-4 py-2 border-b"><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>Edit</td>
                        </tr>
                    <?php } ?>
                </tbody>



            </table>
        <?php } else { ?>
            <p class="text-gray-500">No orders found.</p>
        <?php } ?>
        <?php $db->close(); ?>
    </div>
</div>


    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    <!-- JavaScript to retrieve and display the Facebook account -->
    <script>

        window.onload = function() {
            const facebookAccount = sessionStorage.getItem('facebook_account');
            document.getElementById('facebookAccountCell').innerText = facebookAccount ? facebookAccount : 'N/A';
        };
    </script>
</body>
</html>