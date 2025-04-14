<?php
@include 'config.php';

if(isset($_POST['add_to_wishlist'])){
    $product_Name = $_POST['product_name'];
    $product_Price = $_POST['product_price'];
    $product_Image = $_POST['product_image'];
    $product_Quantity = 1;
    
    $select_wishlist = mysqli_query($conn, "SELECT * from wishlist WHERE name = '$product_Name'");
    
    if(mysqli_num_rows($select_wishlist) > 0){
        $message[] = "Product already added to wishlist";
    } else {
        $insert_products = mysqli_query($conn, "INSERT into wishlist(name, price, image, quantity) 
                              VALUES('$product_Name', '$product_Price', '$product_Image', '$product_Quantity')");
        $message[] = "Product added to wishlist";
    }
}

if(isset($_POST['add_to_cart'])){
    $product_Name = $_POST['product_name'];
    $product_Price = $_POST['product_price'];
    $product_Image = $_POST['product_image'];
    $product_Quantity = 1;
    
    $select_cart = mysqli_query($conn, "SELECT * from cart WHERE name = '$product_Name'");
    
    if(mysqli_num_rows($select_cart) > 0){
        $message[] = "Product already added to cart";
    } else {
        $insert_products = mysqli_query($conn, "INSERT into cart(name, price, image, quantity) 
                              VALUES('$product_Name', '$product_Price', '$product_Image', '$product_Quantity')");
        $message[] = "Product added to cart";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Collection - SoleMates</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <div class="header">SoleMates</div>
    
    <div class="container">
        <div class="action-links">
            <a href="index.php" class="action-btn"><i class="fas fa-plus-circle"></i> Add Product</a>
            <a href="wishlist.php" class="action-btn"><i class="fas fa-heart"></i> Wishlist</a>
            <a href="cart.php" class="action-btn"><i class="fas fa-shopping-cart"></i> Cart</a>
        </div>
        
        <?php 
        if(isset($message)){
            foreach($message as $message){ 
                echo '<div class="message animate__animated animate__fadeIn"><span>'.$message.'</span> 
                      <i class="fas fa-times" onclick="this.parentElement.style.display = \'none\'"></i>
                      </div>';
            };
        };
        ?>
        
        <section class="products">
            <h1 class="heading">Latest Collection</h1>
            
            <div class="box-container">
                <?php
                $select_products = mysqli_query($conn, "SELECT * from products");
                if(mysqli_num_rows($select_products) > 0){
                    while($fetch_product = mysqli_fetch_assoc($select_products)){
                ?>
                <form action="" method="post" class="product-form">
                    <div class="box animate__animated animate__fadeInUp">
                        <div class="image-container">
                            <img src="<?php echo UPLOAD_DIR.$fetch_product['image']; ?>" alt="<?php echo $fetch_product['name']; ?>">
                            <div class="quick-actions">
                                <button type="submit" class="quick-btn" name="add_to_cart" title="Add to Cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                                <button type="submit" class="quick-btn" name="add_to_wishlist" title="Add to Wishlist">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        
                        <h3><?php echo $fetch_product['name']; ?></h3>
                        <div class="price">Rs. <?php echo $fetch_product['price']; ?></div>
                        
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        
                        <div class="btn-container">
                            <button type="submit" class="btn" name="add_to_cart">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button type="submit" class="btn wishlist-btn" name="add_to_wishlist">
                                <i class="fas fa-heart"></i> Wishlist
                            </button>
                        </div>
                    </div>
                </form>
                <?php
                    };
                } else {
                    echo '<div class="empty-message">No products added yet!</div>';
                }
                ?>
            </div>
        </section>
    </div>
    
    <script src="script.js"></script>
</body>
</html>w