<?php
@include 'config.php';
@include 'setting.php';

if(isset($_GET['q']) && $_GET['q'] == 'su') {
    // Verify the transaction with eSewa API
    $url = "https://uat.esewa.com.np/epay/transrec";
    
    $data = [
        'amt' => $_GET['amt'],
        'rid' => $_GET['refId'],
        'pid' => $_GET['oid'],
        'scd' => $merchant_code
    ];
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    
    if(strpos($response, "Success") !== false) {
        // Clear the cart if payment is successful
        mysqli_query($conn, "DELETE FROM cart");
        $message = "Payment successful! Your order #".htmlspecialchars($_GET['oid'])." has been placed.";
    } else {
        $message = "Payment verification failed. Please contact support.";
    }
} else {
    header('Location: cart.php');
    exit();
}
?>