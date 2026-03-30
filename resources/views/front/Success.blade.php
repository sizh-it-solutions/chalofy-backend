<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Payment Successful</title>
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .logo { font-size: 50px; margin-bottom: 15px; }
    h1 { color: #333; margin-bottom: 10px; }
    .status { color: white; padding: 15px; border-radius: 10px; margin: 15px 0; font-size: 18px; font-weight: bold; background: #4CAF50; }
    .manual-button {
        display: none;
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
<div class="logo">✅</div>
<h1>Chalofy</h1>
 
    <div class="status">Payment Successful!</div>
 
    <div id="statusSection">
<button class="manual-button" onclick="redirectToApp()">Open App Now</button>
</div>
</div>
 
<script>
function getStatusAndParams() {
    const urlParams = new URLSearchParams(window.location.search);
    const bookingId = urlParams.get('bookingId') || '';
    const status = window.location.href.includes("payment_success") ? "payment_success" : "other";
    return { status, bookingId };
}
 
function redirectToApp() {
    const { status, bookingId } = getStatusAndParams();
    let appUrl = "chalofy://home";
    let universalUrl = "https://admin.chalofyrentals.in/home";
 
    if (status === "payment_success") {
        appUrl = "chalofy://payment_success" + (bookingId ? "?bookingId=" + bookingId : "");
        universalUrl = "https://admin.chalofyrentals.in/payment_success" + (bookingId ? "?bookingId=" + bookingId : "");
    }
 
    // Try opening app
    window.location.href = appUrl;
 
    // Fallback to universal link
    setTimeout(() => window.location.href = universalUrl, 500);
}
 
function init() {
    const { status } = getStatusAndParams();
    const manualBtn = document.querySelector('.manual-button');
 
    if (status === "payment_success") {
        // Show manual button only
        manualBtn.style.display = "inline-block";
    }
}
 
window.onload = init;
</script>
</body>
</html>