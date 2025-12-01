<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Getting Ready...</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/payment.css">
  <style>
    .top-new {
      max-width: 100%;
      margin: 50px auto;
      background: #fff;
      border-radius: 8px;
      margin-bottom: 0px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, );
    }

    .payment-list {
      max-width: 100%;
      margin: 50px auto;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      margin-top: 0px;
    }

    .payment-item {
      /* display: flex; */
      align-items: center;
      justify-content: space-between;
      padding: 15px 11px;
      border-bottom: 1px solid #ddd;
      cursor: pointer;
      transition: background 0.3s;
    }

    .payment-item:hover {
      background: #f1f1f1;
    }

    .payment-item img {
      width: 87px;
      height: 43px;
      object-fit: contain;
      margin-right: 35px;
    }

    .payment-item span {
      font-size: 16px;
      color: #333;
    }

    .payment-item .arrow {
      font-size: 29px;
      color: #888;
      position: relative;
      top: -2px;
      float: right;
      padding-right: 15px;
    }

    .payment-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.payment-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.payment-button:focus {
    outline: none;
    box-shadow: none;
}

  </style>

</head>

<body>
  <div class="loader-overlay" style='display:none'>
    <div class="loader"></div>
    <div class="loader-text">In process ...</div>
  </div>
  <div class="container">



  <div class="text-center top-new" style="margin-top:30px;">
    <p class="text-muted mb-4 d-flex align-items-center justify-content-center" style="font-size: 0.95rem;">
        Please select your preferred payment method below to proceed securely.
    </p>
</div>



    <div class="payment-list">
      <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($details['active']): ?>
      <div class="payment-item" <?php if($method == 'paypal'): ?> class="noinel" <?php endif; ?> <?php if($method == 'stripe'): ?>
      id="<?php echo e($details['id']); ?>" <?php endif; ?>>
      <?php if($details['form']): ?>
      <!-- Form Submission for Payment Method -->
      <form action="<?php echo e($details['route']); ?>" method="post" id="<?php echo e($details['id']); ?>" class="payment-form">
      <?php echo csrf_field(); ?>
      <!-- Wrapping the whole payment item in a clickable area -->
      <div onclick="document.getElementById('<?php echo e($method); ?>-button').click()">
      <img src="<?php echo e($details['image']); ?>" alt="Pay via <?php echo e(ucfirst($method)); ?>" class="payment-image">
      <span class="payment-method-name"><?php echo e(ucfirst($method)); ?></span>
      <span class="arrow">&#8250;</span>
      <button type="submit" style="display: none;" id="<?php echo e($method); ?>-button">
        <!-- Hidden submit button for form submission -->
      </button>
      </div>
      </form>
      <?php else: ?>
      <!-- Link for Payment Method without Form -->
      <a href="<?php echo e($details['route']); ?>">
      <!-- Make the whole div clickable -->
      <img src="<?php echo e($details['image']); ?>" alt="Pay via <?php echo e(ucfirst($method)); ?>" class="payment-image">
      <span class="payment-method-name"><?php echo e(ucfirst($method)); ?></span>
      <span class="arrow">&#8250;</span>
      </a>
      <?php endif; ?>

      </div>
    <?php endif; ?>
      <?php if($method == 'stripe' && Route::currentRouteName() == 'wallet_recharge_form'): ?>
      <?php break; ?>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

  </div>
  <div class="modal fade" id="stripeModal" tabindex="-1" role="dialog" aria-labelledby="stripeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="stripeModalLabel">Stripe Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form
            action="<?php echo e(Route::currentRouteName() == 'wallet_recharge_form' ? route('wallet_recharge_form', ['userToken' => request()->query('token'), 'method' => 'stripe', 'amount' => request()->query('amount'), 'currency' => request()->query('currency')]) : route('payment', ['booking' => $bookingId, 'method' => 'stripe'])); ?>"
            method="post" id="payment-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" id="order_id" name="order_id" value="<?php echo e(request()->query('booking')); ?>" required>
            <input type="hidden" name="stripeToken" id="stripeToken">
            <input type="hidden" name="userToken" id="userToken" value="<?php echo e(request()->query('token')); ?>">
            <input type="hidden" name="amount" id="amount" value="<?php echo e(request()->query('amount')); ?>">
            <input type="hidden" name="currency" id="currency" value="<?php echo e(request()->query('currency')); ?>">
            <div class="form-group">
              <label for="card-number">Card Number</label>
              <div id="card-number" class="form-control"></div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="card-expiry">Expiration Date</label>
                <div id="card-expiry" class="form-control"></div>
              </div>
              <div class="form-group col-md-6">
                <label for="card-cvc">CVV Code</label>
                <div id="card-cvc" class="form-control"></div>
              </div>
            </div>

            <div id="card-errors" role="alert" class="alert alert-danger" style="display:none"></div>
            <div id="error-message" class="alert alert-danger" role="alert" style="display: none;"></div>
            <div id="loader" class="spinner-border text-primary" role="status" style="display: none;">
              <span class="sr-only">Loading...</span>
            </div>
            <button type="submit" id="submit-button" class="btn btn-primary btn-block mt-3">Submit Payment</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Bootstrap JS and jQuery scripts here -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- Include Stripe.js script -->
  <script src="https://js.stripe.com/v3/"></script>


  <!-- JavaScript for the loader and Stripe integration -->
  <script>
    $(document).ready(function () {

      $("#paypal-form").submit(function (event) {
        event.preventDefault();
        $('.loader-overlay').show();
        this.submit();
      });


      $("#razorpay-form").submit(function (event) {
        event.preventDefault();
        $('.loader-overlay').show();
        this.submit();
      });

      $("#payduniya-form").submit(function (event) {
        event.preventDefault();
        $('.loader-overlay').show();
        this.submit();
      });

$("#transbank-form").submit(function (event) {
    event.preventDefault();
    $('.loader-overlay').show();
    this.submit();
});
      $("#stripe-link").click(function () {
        console.log("Clicked on Stripe link");
        $('#stripeModal').modal('show');
      });



      $("#stripe-submit").click(function () {
        $('#stripeModal').modal('hide');
      });
    });

    var stripe = Stripe('<?php echo e($paymentMethods['stripe']['public_key']); ?>');
    var elements = stripe.elements();


    var style = {
      base: {
        fontSize: '16px',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        color: '#32325d',
      },
    };

    var cardNumber = elements.create('cardNumber', { style: style });
    cardNumber.mount('#card-number');

    var cardExpiry = elements.create('cardExpiry', { style: style });
    cardExpiry.mount('#card-expiry');

    var cardCvc = elements.create('cardCvc', { style: style });
    cardCvc.mount('#card-cvc');

    var form = document.getElementById('payment-form');
    var submitButton = document.getElementById('submit-button');

    form.addEventListener('submit', function (event) {
      event.preventDefault();
      submitButton.disabled = true;
      loader.style.display = 'block'; // Show the loader
      stripe.createToken(cardNumber).then(function (result) {
        if (result.error) {
          // Inform the user if there was an error.

          var errorElement = document.getElementById('card-errors');
          errorElement.style.display = 'block';
          errorElement.textContent = result.error.message;
          loader.style.display = 'none';
          submitButton.disabled = false;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });

    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      var hiddenInput = document.getElementById('stripeToken');
      hiddenInput.setAttribute('value', token.id);
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);

      // Submit the form
      form.submit();
    }

    var errorMessage = '<?php echo e(session("error")); ?>';
    if (errorMessage) {
      var errorMessageElement = document.getElementById('error-message');
      errorMessageElement.textContent = errorMessage;
      errorMessageElement.style.display = 'block';
    }
  </script>




</body>

</html><?php /**PATH /home/u946908376/domains/admin.chalofyrentals.in/public_html/resources/views/front/payment.blade.php ENDPATH**/ ?>