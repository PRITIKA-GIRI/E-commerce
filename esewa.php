<?php
@include 'config.php';
@include 'setting.php';

// Calculate cart total
$select_cart = mysqli_query($conn, "SELECT * from cart");
$grand_total = 0;

if(mysqli_num_rows($select_cart) > 0) {
    while($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
        $grand_total += $sub_total;
    }
}

// Delivery charge instead of tax
$delivery_charge = 150; // Flat delivery charge
$total_amount = $grand_total + $delivery_charge;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - SoleMates</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <div class="logo">SoleMates</div>
            <div class="secure-badge">
                <i class="fas fa-lock"></i> Secure Checkout
            </div>
        </div>
        
        <div class="payment-card">
            <div class="payment-branding">
                <img src="uploaded_img/esewa.jpg" alt="eSewa" class="esewa-logo">
                <h2>Payment Authorization</h2>
                <p>You'll be redirected to eSewa to complete your payment securely</p>
            </div>
            
            <div class="order-summary">
                <h2>Order Summary</h2>
                <div class="summary-grid">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rs. <?php echo number_format($grand_total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Charge:</span>
                        <span>Rs. <?php echo number_format($delivery_charge, 2); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Amount:</span>
                        <span>Rs. <?php echo number_format($total_amount, 2); ?></span>
                    </div>
                </div>
            </div>
            
            <form action="<?php echo $epay_url; ?>" method="POST" id="esewaForm" class="payment-form">
                <!-- Hidden required fields -->
                <input type="hidden" id="amount" name="amount" value="<?php echo $grand_total; ?>">
                <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="<?php echo $delivery_charge; ?>">
                <input type="hidden" id="product_service_charge" name="product_service_charge" value="0">
                <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>">
                <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
                <input type="hidden" id="product_code" name="product_code" value="EPAYTEST">
                <input type="hidden" id="tax_amount" name="tax_amount" value="0">

                <input type="hidden" id="success_url" name="success_url" value="<?php echo $success_url; ?>">
                <input type="hidden" id="failure_url" name="failure_url" value="<?php echo $failure_url; ?>">
                <input type="hidden" id="signed_field_names" name="signed_field_names" 
                       value="total_amount,transaction_uuid,product_code">
                <input type="hidden" id="signature" name="signature" required>
                
                <button type="submit" class="payment-button">
                    <span class="button-content">
                        <i class="fas fa-lock"></i>
                        <span>Pay Rs. <?php echo number_format($total_amount, 2); ?></span>
                    </span>
                </button>
            </form>
            
            <div class="payment-footer">
                <a href="cart.php" class="back-link"><i class="fas fa-arrow-left"></i> Return to cart</a>
                <div class="help-link">
                    Need help? <a href="contact.php">Contact support</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        generateSignature();
        
        // Form submission handler
        document.getElementById('esewaForm').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        });
    });

    function generateSignature() {
        const now = new Date();
        const transactionId = now.toISOString().slice(2, 10).replace(/-/g, '') + '-' + 
                             now.getHours().toString().padStart(2, '0') + 
                             now.getMinutes().toString().padStart(2, '0') + 
                             now.getSeconds().toString().padStart(2, '0');
        
        document.getElementById("transaction_uuid").value = transactionId;

        const totalAmount = document.getElementById("total_amount").value;
        const productCode = document.getElementById("product_code").value;
        const secret = "<?php echo $secret_key; ?>";

        const signatureData = `total_amount=${totalAmount},transaction_uuid=${transactionId},product_code=${productCode}`;
        const hash = CryptoJS.HmacSHA256(signatureData, secret);
        const signature = CryptoJS.enc.Base64.stringify(hash);
        
        document.getElementById("signature").value = signature;
    }
    </script>
</body>
</html>
