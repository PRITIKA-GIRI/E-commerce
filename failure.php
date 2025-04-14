<?php
// failure.php
@include 'config.php';
@include 'setting.php';

if(isset($_GET['q']) && $_GET['q'] == 'fu') {
    $message = "Payment failed. Please try again.";
} else {
    header('Location: cart.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Failed</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">Watch Haven</div>
    <div class="container">
        <div class="message error">
            <span><?php echo $message; ?></span>
        </div>
        <a href="cart.php" class="btn">Back to Cart</a>
    </div>
</body>
</html>