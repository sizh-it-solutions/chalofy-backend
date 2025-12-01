<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirecting to Transbank...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #f9f9f9;
        }
        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .text {
            font-size: 16px;
            color: #555;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="text">
        <div class="loader"></div>
        <p>Redirecting to Transbank for payment, please wait...</p>
        <form id="transbankForm" action="{{ $url }}" method="POST">
            <input type="hidden" name="token_ws" value="{{ $token }}">
            <noscript>
                <p>JavaScript is disabled. Please click the button below to proceed.</p>
                <button type="submit">Proceed to Payment</button>
            </noscript>
        </form>
    </div>

    <script>
        document.getElementById('transbankForm').submit();
    </script>
</body>
</html>
