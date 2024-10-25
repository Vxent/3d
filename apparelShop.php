<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Fetch products from the database
$query = "SELECT id, name, description, price, image_url FROM products"; // Adjust table name as needed
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
<body>
<nav class="bg-black shadow-md top-0 left-0 w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-2">
            <div class="flex-1 flex justify-start">
                <div class="hidden md:flex space-x-4 p-2">
                    <a href="index.php" class="text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">Home</a>
                    
                    <a href="#about" class="text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">About</a>
                    <a href="#threats" class="text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">Services</a>
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="text-center">
                    <img src="images/logo1.png" alt="" width="200px" class="h-20">  
                </div>
            </div>
            <div class="flex-1 flex justify-end">
                <div class="hidden md:flex space-x-4 p-2">
                    
                    <a href="contacts.html" class="text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">Contacts</a>
                    <a href="order_history.php" class="text-gray-700 px-2 py-1 font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-sm hover:underline">History Order</a>
                    <a href="index.php" class="border-2 border-white bg-black text-white py-2 px-4 rounded">Back</a>
                </div>
            </div>
            <!-- Hamburger Button for Mobile View -->
            <div class="md:hidden flex items-center">
                <button id="navbar-toggle" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="navbar-menu" class="navbar-menu md:hidden hidden">
        <a href="#Main" class="block px-4 py-2 text-white hover:bg-gray-700">Home</a>
        <a href="#varieties" class="block px-4 py-2 text-white hover:bg-gray-700">Sports</a>
        <a href="#about" class="block px-4 py-2 text-white hover:bg-gray-700">About</a>
        <a href="contacts.html" class="block px-4 py-2 text-white hover:bg-gray-700">Contacts</a>
    </div>
</nav>

<!-- Navbar Script -->
<script>
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        var menu = document.getElementById('navbar-menu');
        menu.classList.toggle('hidden'); // Toggle the 'hidden' class
    });
</script>


    <!-- Your shop content here -->
     <h1 class="text-2xl text-center mt-5 mb-5 font-bold text-orange-700">READYMADE JERSEY'</h1>
    <div class="flex flex-wrap justify-start">
    <?php while ($product = $result->fetch_assoc()): ?>
        <div class="w-full md:w-1/2 lg:w-1/6 p-4">
            <div class="border p-4 bg-white rounded-lg shadow-lg">
            <h5 class="w-full h-10 object-cover rounded-t-lg font-bold text-center uppercase"><?php echo htmlspecialchars($product['name']); ?></h5>
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product Image" class="w-full h-48 object-cover rounded-t-lg">
                
                <p class="text-sm font-bold text-center text-gray-700"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="text-xl font-bold text-center text-gray-700">$<?php echo htmlspecialchars($product['price']); ?></p>
                <div class="flex justify-center mt-2">
                    <a href="orderForm.php?product_id=<?php echo $product['id']; ?>">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">BUY NOW</button>
                    </a>

                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<footer class="bg-black text-white p-8">
    <div class="container mx-auto">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-bold">Services</h2>
                <ul>
                    <li><a href="#" class="hover:underline">Web Development</a></li>
                    <li><a href="#" class="hover:underline">Graphic Design</a></li>
                    <li><a href="#" class="hover:underline">SEO Services</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-lg font-bold">Contact</h2>
                <p>Email: <a href="mailto:info@example.com" class="hover:underline">info@example.com</a></p>
            </div>
            <div>
                <h2 class="text-lg font-bold">Follow Us</h2>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.35C0 23.4.6 24 1.325 24h21.35C23.4 24 24 23.4 24 22.675V1.325C24 .6 23.4 0 22.675 0zM12 3c2.2 0 3.59 1.36 3.59 3.48v2.82H18l-1.32 3.89h-3.68V24H9.32V10.2H7V6.31h2.32V4.5c0-2.13 1.16-3.5 3.7-3.5z"/></svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="hover:text-purple-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.736 0 5.5.007 5.5 0c-2.644.008-5.5 2.72-5.5 5.5C0 8.736 0 12 0 12s0 3.264 0 6.5C0 22.28 2.72 24 5.5 24c3.264 0 6.5-.007 6.5-.007s3.264 0 6.5 0c2.78 0 5.5-2.72 5.5-5.5C24 15.264 24 12 24 12s0-3.264 0-6.5c0-2.78-2.72-5.5-5.5-5.5C15.264 0 12 0 12 0zm0 2.25c3.964 0 7.25 3.29 7.25 7.25S15.964 16.75 12 16.75 4.75 13.46 4.75 10.5 8.036 2.25 12 2.25zm0 2.75a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm7.125-.375c0 .414-.336.75-.75.75s-.75-.336-.75-.75.336-.75.75-.75.75.336.75.75z"/></svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="hover:text-blue-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.954 4.569c-.885.392-1.83.655-2.825.775 1.014-.609 1.794-1.572 2.163-2.724-.951.566-2.005.977-3.127 1.195-.894-.952-2.167-1.54-3.583-1.54-2.71 0-4.913 2.199-4.913 4.913 0 .385.045.761.127 1.124-4.083-.205-7.703-2.161-10.125-5.144-.423.725-.666 1.562-.666 2.465 0 1.699.865 3.191 2.179 4.066-.805-.026-1.564-.247-2.228-.616v.062c0 2.38 1.69 4.372 3.938 4.831-.412.111-.844.171-1.287.171-.315 0-.621-.031-.922-.086.623 1.946 2.433 3.365 4.575 3.405-1.677 1.314-3.785 2.095-6.075 2.095-.394 0-.782-.023-1.164-.067 2.167 1.386 4.748 2.194 7.508 2.194 9.005 0 13.905-7.459 13.905-13.903 0-.211-.005-.422-.014-.632.954-.688 1.775-1.55 2.425-2.53z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>