<html>
<head>
    <title>Razorpay Payment Page</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                "key": "<?php echo e($apiKey); ?>", // Your Razorpay key ID
                "amount": "<?php echo e($orderDetails['amount']); ?>", // Amount in paise
                "currency": "<?php echo e($orderDetails['currency']); ?>",
                "description": "Purchase Description",
                "order_id": "<?php echo e($orderDetails['id']); ?>", // Razorpay Order ID
                "handler": function (response) {
                    var bookingId = <?php echo e($bookingId); ?>;  // The booking ID passed from the backend
                    var method = 'razorpay';  // Payment method (this can be dynamic if needed)
                    console.log('Payment Response:', response);
                    
                    
                    var returnUrl = "<?php echo e(url('handleRazorpay/return')); ?>?booking=" + bookingId + "&method=" + method;
                    returnUrl += '&razorpay_payment_id=' + response.razorpay_payment_id +
                        '&razorpay_order_id=' + response.razorpay_order_id +
                        '&razorpay_signature=' + response.razorpay_signature;

                    // Redirect to the callback URL
                    console.log('Redirecting to:', returnUrl);
                    window.location.href = returnUrl;
                }
            };

            // Initialize Razorpay
            var rzp1 = new Razorpay(options);

            // Automatically open Razorpay payment modal when page loads
            rzp1.open();
        });
    </script>
</body>
</html>
<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/front/razorpay-payment.blade.php ENDPATH**/ ?>