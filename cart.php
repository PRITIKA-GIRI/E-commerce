<?php
@include 'config.php';

if(isset($_POST['update_update_btn'])){
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_query = mysqli_query($conn, "UPDATE cart SET quantity='$update_value' WHERE id='$update_id'");
    
    if($update_query){
        header('location:cart.php');
    }
}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE from cart WHERE id='$remove_id'");
    header('location:cart.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE from cart");
    header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - SoleMates </title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">SoleMates </div>
    
    <div class="container">
        <div class="action-links">
            <a href="index.php" class="action-btn"><i class="fas fa-plus-circle"></i> Add Product</a>
            <a href="display.php" class="action-btn"><i class="fas fa-shopping-bag"></i> Continue Shopping</a>
            <a href="wishlist.php" class="action-btn"><i class="fas fa-heart"></i> Wishlist</a>
        </div>
        
        <section class="shopping-cart">
            <h1 class="heading">Your Shopping Cart</h1>
            
            <?php
            $select_cart = mysqli_query($conn, "SELECT * from cart");
            $grand_total = 0;
            
            if(mysqli_num_rows($select_cart) > 0) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                    while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $grand_total += $sub_total;
                    ?>
                    <tr>
                        <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="<?php echo $fetch_cart['name']; ?>"></td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>Rs.<?php echo number_format($fetch_cart['price'], 2); ?></td>
                        <td>
                            <form action="" method="post" class="quantity-form">
                                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                <button type="submit" name="update_update_btn" class="update-btn"><i class="fas fa-sync-alt"></i></button>
                            </form>
                        </td>
                        <td>Rs.<?php echo number_format($sub_total, 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" 
                               onclick="return confirm('Remove item from cart?')" class="delete-btn">
                                <i class="fas fa-trash"></i> Remove
                            </a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                    
                    <tr class="table-bottom">
                        <td colspan="4"><strong>Grand Total</strong></td>
                        <td><strong>Rs.<?php echo number_format($grand_total, 2); ?></strong></td>
                        <td>
                            <a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to clear your cart?');" 
                               class="delete-btn">
                                <i class="fas fa-trash"></i> Clear All
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="checkout-btn">
                <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
                    <i class="fas fa-credit-card"></i> Proceed to Checkout
                </a>
            </div>
            <?php
            } else {
                echo '<div class="message" style="text-align: center; margin: 2rem 0;">
                        <span><i class="fas fa-shopping-cart"></i> Your cart is empty</span>
                      </div>';
            }
            ?>
        </section>
    </div>
    
    <script src="script.js"></script>
</body>
</html>