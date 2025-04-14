<?php
// eSewa payment configuration - TEST ENVIRONMENT
$epay_url = "https://rc-epay.esewa.com.np/api/epay/main/v2/form"; // Test environment URL
$pid = "EPAYTEST";
$success_url = "http://localhost/ecommerce/success.php?q=su"; // Update with your local URL
$failure_url = "http://localhost/ecommerce/failure.php?q=fu"; // Update with your local URL
$merchant_code = "EPAYTEST";
$secret_key = "8gBm/:&EnhH.1/q"; // From your credentials

// For SDK integration (if needed)
$client_id = "JB0BBQ4aD0UqIThFJwAKBgAXEUkEGQUBBAwdOgABHD4DChwUAB0R";
$client_secret = "BhwIWQQADhIYSxILExMcAgFXFhcOBwAKBgAXEQ==";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>