<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce_db');

// Upload directory
define('UPLOAD_DIR', 'uploaded_img/');

// Create database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Add to the existing table creation queries
$sql_categories = "CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
)";

$sql_products = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
)";



$sql_cart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    quantity INT NOT NULL
)";

$sql_wishlist = "CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    quantity INT NOT NULL
)";
mysqli_query($conn, $sql_categories);
mysqli_query($conn, $sql_products);
mysqli_query($conn, $sql_cart);
mysqli_query($conn, $sql_wishlist);
// Google Analytics Minimal Setup
function init_analytics() {
    $ga_id = "G-XXXXXXXXXX"; // ← Replace with your ID from Step 1
    
    echo <<<HTML
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=$ga_id"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '$ga_id');
      
      // Auto-track basic page views
      gtag('event', 'page_view', {
        page_title: document.title,
        page_path: window.location.pathname
      });
    </script>
HTML;
}
init_analytics();
?>