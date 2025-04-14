<?php
@include 'config.php';

if(isset($_POST['add_to_cart'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;
    
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
    
    if(mysqli_num_rows($select_cart) > 0) {
        $message[] = 'Product already added to cart';
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) 
                              VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
        $message[] = 'Product added to cart successfully';
    }
}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE from wishlist WHERE id='$remove_id'");
    header('location:wishlist.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wishlist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if(isset($message)) {
        foreach($message as $message) {
            echo '<div class="message"><span>'.$message.'</span>
                  <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i>
                  </div>';
        }
    }
    ?>
    
    <div class="container">
        <div style="text-align: right; margin: 20px;">
            <a href="index.php" class="action-btn">Add product</a>
            <a href="display.php" class="action-btn">All Products</a>
            <a href="cart.php" class="action-btn">Cart</a>
        </div>
        
        <section class="products">
            <h1 class="heading">Wishlist</h1>
            
            <div class="box-container">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM wishlist");
                
                if(mysqli_num_rows($select_products) > 0) {
                    while($fetch_product = mysqli_fetch_assoc($select_products)) {
                ?>
                <form action="" method="post">
                    <div class="box">
                        <img src="<?php echo UPLOAD_DIR.$fetch_product['image']; ?>" alt="">
                        <h3><?php echo $fetch_product['name']; ?></h3>
                        <div class="price">Rs.<?php echo $fetch_product['price']; ?></div>
                        
                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        
                        <input type="submit" class="btn" value="Add to cart" name="add_to_cart">
                        <a href="wishlist.php?remove=<?php echo $fetch_product['id']; ?>" 
                           onclick="return confirm('Remove item from wishlist?')" class="delete-btn">
                            <i class="fas fa-trash"></i> Remove
                        </a>
                    </div>
                </form>
                <?php
                    }
                }
                ?>
            </div>
        </section>
    </div>
</body>
</html>