<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      background-color: #F8FAF5;
      flex-direction: column;
      font-family: Arial, sans-serif;
    }
    .loader {
      border: 8px solid #4CAF50;
      border-top: 8px solid #ffffff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-bottom: 20px;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .message {
      font-size: 1.2rem;
      color: #333;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="loader"></div>
  <div class="message">Payment is processing, please wait...</div>

  <script>
    var bookingId = "<?php echo e($bookingId); ?>"; // Pass this from controller

    var pollInterval = 3000; // 3 seconds
    var attempts = 0;
    var maxAttempts = 40; // ~2 minutes timeout

    function checkPaymentStatus() {
        $.ajax({
            url: '<?php echo e(route("payment_status")); ?>',
            method: 'GET',
            data: { bookingId: bookingId },  // changed from orderId to bookingId
            success: function(data) {
            if(data.payment_status === 'paid' && data.payment_method === 'phonepe') {
                window.location.href = '/payment_success';
            } else if(data.payment_status === 'failed') {
                window.location.href = '/payment_fail';
            } else {
                attempts++;
                if(attempts >= maxAttempts) {
                window.location.href = '/payment_fail';
                } else {
                setTimeout(checkPaymentStatus, pollInterval);
                }
            }
            },
            error: function() {
            attempts++;
            if(attempts >= maxAttempts) {
                window.location.href = '/payment-fail';
            } else {
                setTimeout(checkPaymentStatus, pollInterval);
            }
            }
        });
        }


    $(document).ready(function() {
      checkPaymentStatus();
    });
  </script>
</body>
</html>
<?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/front/pending.blade.php ENDPATH**/ ?>