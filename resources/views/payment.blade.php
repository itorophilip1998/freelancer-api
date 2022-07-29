<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment</title>
    <link rel="stylesheet" href="https://static.unzer.com/v1/unzer.css" />

</head>
<body>
    

<form id="payment-form" class="unzerUI form" novalidate>
  <div class="field">
    <div id="card-element-id-number" class="unzerInput">
        <!-- Card number UI Element will be inserted here. -->
    </div>
  </div>
  <div class="two fields">
    <div class="field ten wide">
      <div id="card-element-id-expiry" class="unzerInput">
        <!-- Card expiry date UI Element will be inserted here. -->
      </div>
    </div>
    <div class="field six wide">
      <div id="card-element-id-cvc" class="unzerInput">
        <!-- Card CVC UI Element will be inserted here. -->
      </div>
    </div>
  </div>
  <div class="field">
    <button id="submit-button" class="unzerUI primary button fluid" type="submit">
      Pay
    </button>
  </div>
</form>

    <script type="text/javascript" src="https://static.unzer.com/v1/unzer.js"></script>
<script>
    // Creating a unzer instance with your public key
let unzerInstance = new unzer('727e2abb4bcacc098c7140c866c2f1b47a9694e5cd5614e6116466147217b958');

// Creating a credit card instance
let card = unzerInstance.Card()
// Rendering input fields
card.create('number', {
  containerId: 'card-element-id-number'
});
card.create('expiry', {
  containerId: 'card-element-id-expiry'
});
card.create('cvc', {
  containerId: 'card-element-id-cvc'
});

// Optional
card.create('holder', {
  containerId: 'card-element-id-holder'
});
</script>
</body>
</html>