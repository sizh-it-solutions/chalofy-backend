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
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            font-size: 18px;
            font-weight: bold;
        }
        .countdown {
            color: #666;
            margin: 15px 0;
        }
        .loader {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #007aff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
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
        <div class="logo">🏨</div>
        <h1>Chalofy</h1>
        
        <!-- Success Section -->
        <div id="successSection" style="display: none;">
            <div class="status">Payment Successful!</div>
            <div class="countdown">
                <div class="loader"></div>
                <p>Redirecting to app in <span id="countdown">3</span> seconds...</p>
            </div>
            <button class="manual-button" onclick="redirectToApp()">Open App Now</button>
        </div>
        
        <!-- Error Section -->
        <div id="errorSection" style="display: none;">
            <div class="status" style="background: #f44336;">Page Not Found</div>
            <p>The requested page could not be found.</p>
        </div>
    </div>

    <script>
        // Check if URL contains payment_success
        function hasPaymentSuccess() {
            return window.location.href.includes("payment_success");
        }

        // Redirect to Chalofy app using iframe method (bypasses prompt)
        function redirectToApp() {
            // Try multiple methods to open app without prompt
            const appUrl = "chalofy://booking/status";
            
            // Method 1: Direct location change (may still show prompt on some browsers)
            window.location.href = appUrl;
            
            // Method 2: Iframe method to bypass prompt
            setTimeout(() => {
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = appUrl;
                document.body.appendChild(iframe);
                
                // Remove iframe after a short time
                setTimeout(() => {
                    document.body.removeChild(iframe);
                }, 100);
            }, 50);
            
            // Method 3: Window open as fallback
            setTimeout(() => {
                window.open(appUrl, '_self');
            }, 1000);
        }

        // Initialize page
        function init() {
            if (hasPaymentSuccess()) {
                // Show success section and start countdown
                document.getElementById('successSection').style.display = 'block';
                
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
                document.getElementById('errorSection').style.display = 'block';
            }
        }

        // Start when page loads
        window.onload = init;
    </script>
</body>
</html>