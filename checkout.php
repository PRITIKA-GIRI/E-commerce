<?php
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $method = $_POST['method'];

    $select_cart = mysqli_query($conn, "SELECT * FROM cart");
    $grand_total = 0;

    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
            $grand_total += $sub_total;
        }
    }

    $_SESSION['grand_total'] = $grand_total;

    if ($method === 'esewa') {
        header("Location: esewa.php?total=$grand_total");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - SoleMates</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">SoleMates</div>

    <div class="container">
        <section class="checkout-form">
            <h1 class="heading">Complete Your Order</h1>

            <div class="display-order">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM cart");
                $grand_total = 0;

                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                        $grand_total += $sub_total;
                    }
                }
                ?>
                <span class="grand-total">Order Total: Rs. <?= number_format($grand_total, 2); ?></span>
            </div>

            <form action="" method="post">
                <div class="flex">
                    <div class="inputBox">
                        <span>Your Name</span>
                        <input type="text" name="name" placeholder="Full Name" required>
                    </div>

                    <div class="inputBox">
                        <span>Phone Number</span>
                        <input type="tel" name="number" placeholder="98XXXXXXXX" required>
                    </div>

                    <div class="inputBox">
                        <span>Email</span>
                        <input type="email" name="email" placeholder="you@example.com" required>
                    </div>

                    <div class="inputBox">
                        <span>City</span>
                        <input type="text" name="city" placeholder="Your City" required>
                    </div>

                    <div class="inputBox">
                        <span>Country</span>
                        <input type="text" name="country" placeholder="Your Country" required>
                    </div>

                    <div class="inputBox">
                        <span>Payment Method</span>
                        <select name="method" required>
                            <option value="esewa" selected>eSewa</option>
                            <option value="cod" disabled>Cash on Delivery (Coming Soon)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" name="order_btn" class="btn">
                    <i class="fas fa-paper-plane"></i> Place Order
                </button>
            </form>
        </section>
    </div>
</body>
</html>
