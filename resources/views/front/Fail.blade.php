<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chalofy Booking Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 350px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .logo {
            font-size: 50px;
            margin-bottom: 15px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .status {
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .success { background: #4CAF50; }
        .fail { background: #f44336; }
        .invalid { background: #ff9800; }
        
        .countdown {
            color: #666;
            margin: 15px 0;
        }
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        .success-loader { border-top: 3px solid #4CAF50; }
        .fail-loader { border-top: 3px solid #f44336; }
        .invalid-loader { border-top: 3px solid #ff9800; }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .manual-button {
            display: inline-block;
            background: #007aff;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px 0;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo" id="pageLogo">🏨</div>
        <h1>Chalofy</h1>
        
        <div id="statusSection" style="display: none;">
            <div class="status" id="statusMessage">Payment Successful!</div>
            <div class="countdown">
                <div class="loader" id="statusLoader"></div>
                <p>Redirecting to app in <span id="countdown">3</span> seconds...</p>
            </div>
            <button class="manual-button" onclick="redirectToApp()">Open App Now</button>
        </div>
        
        <div id="errorSection" style="display: none;">
            <div class="status invalid">Page Not Found</div>
            <p>The requested page could not be found.</p>
        </div>
    </div>

    <script>
        // Get status from URL and extract bookingId
        function getStatusAndParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const bookingId = urlParams.get('bookingId');
            const status = urlParams.get('status');
            
            let detectedStatus = "home";
            if (window.location.href.includes("payment_success")) detectedStatus = "payment_success";
            if (window.location.href.includes("payment_fail")) detectedStatus = "payment_fail";
            if (window.location.href.includes("invalid-order")) detectedStatus = "invalid-order";
            if (window.location.href.includes("booking_status")) detectedStatus = "booking_status";
            
            return {
                status: detectedStatus,
                bookingId: bookingId
            };
        }

        // Redirect to Chalofy app - CORRECTED URLs to match AndroidManifest
        function redirectToApp() {
            const { status, bookingId } = getStatusAndParams();
            let appUrl = "chalofy://home";
            let universalUrl = "https://admin.chalofyrentals.in/home";
            
            // Set URLs based on status - MATCHING ANDROIDMANIFEST INTENT FILTERS
            if (status === "payment_success") {
                appUrl = "chalofy://payment_success" + (bookingId ? "?bookingId=" + bookingId : "");
                universalUrl = "https://admin.chalofyrentals.in/payment_success" + (bookingId ? "?bookingId=" + bookingId : "");
            } else if (status === "payment_fail") {
                appUrl = "chalofy://payment_fail" + (bookingId ? "?bookingId=" + bookingId : "");
                universalUrl = "https://admin.chalofyrentals.in/payment_fail" + (bookingId ? "?bookingId=" + bookingId : "");
            } else if (status === "invalid-order") {
                appUrl = "chalofy://invalid-order" + (bookingId ? "?bookingId=" + bookingId : "");
                universalUrl = "https://admin.chalofyrentals.in/invalid-order" + (bookingId ? "?bookingId=" + bookingId : "");
            } else if (status === "booking_status") {
                appUrl = "chalofy://booking_status" + (bookingId ? "?bookingId=" + bookingId : "");
                universalUrl = "https://admin.chalofyrentals.in/booking_status" + (bookingId ? "?bookingId=" + bookingId : "");
            }
            
            console.log('🔗 Attempting to open app with:', appUrl);
            console.log('🌍 Universal link:', universalUrl);
            
            // Try custom scheme first
            window.location.href = appUrl;
            
            // Fallback to universal link after delay
            setTimeout(() => {
                console.log('🔄 Falling back to universal link');
                window.location.href = universalUrl;
            }, 500);
            
            // Additional fallback - create iframe for custom schemes
            setTimeout(() => {
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = appUrl;
                document.body.appendChild(iframe);
                
                setTimeout(() => {
                    document.body.removeChild(iframe);
                }, 100);
            }, 100);
        }

        // Initialize page
        function init() {
            const { status, bookingId } = getStatusAndParams();
            const statusSection = document.getElementById('statusSection');
            const errorSection = document.getElementById('errorSection');
            const statusMessage = document.getElementById('statusMessage');
            const statusLoader = document.getElementById('statusLoader');
            const logo = document.getElementById('pageLogo');

            console.log('📊 Detected status:', status);
            console.log('📋 Booking ID:', bookingId);
            console.log('🌐 Current URL:', window.location.href);

            if (status !== "home") {
                // Show status section
                statusSection.style.display = 'block';
                
                // Update based on status
                if (status === "payment_success" || status === "booking_status") {
                    statusMessage.textContent = "Payment Successful!";
                    statusMessage.className = "status success";
                    statusLoader.className = "loader success-loader";
                    logo.textContent = "✅";
                } else if (status === "payment_fail") {
                    statusMessage.textContent = "Payment Failed";
                    statusMessage.className = "status fail";
                    statusLoader.className = "loader fail-loader";
                    logo.textContent = "❌";
                } else if (status === "invalid-order") {
                    statusMessage.textContent = "Invalid Order";
                    statusMessage.className = "status invalid";
                    statusLoader.className = "loader invalid-loader";
                    logo.textContent = "⚠️";
                }
                
                // Start countdown
                let seconds = 3;
                const countdownElement = document.getElementById('countdown');
                
                const countdown = setInterval(() => {
                    seconds--;
                    countdownElement.textContent = seconds;
                    
                    if (seconds <= 0) {
                        clearInterval(countdown);
                        redirectToApp();
                    }
                }, 1000);
            } else {
                // Show error section
                errorSection.style.display = 'block';
            }
        }

        // Start when page loads
        window.onload = init;

        // Also log when page becomes visible again (when returning from app)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                console.log('🔄 Page became visible again - user likely returned from app');
                console.log('📊 Current URL:', window.location.href);
            }
        });
    </script>
</body>
</html>