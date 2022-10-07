<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      display: flex;
      flex-direction: column;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }

    .button {
      cursor: pointer;
      font-weight: 500;
      left: 3px;
      line-height: inherit;
      position: relative;
      text-decoration: none;
      text-align: center;
      border-style: solid;
      border-width: 1px;
      border-radius: 3px;
      -webkit-appearance: none;
      -moz-appearance: none;
      display: inline-block;
    }

    .button--small {
      padding: 10px 20px;
      font-size: 0.875rem;
    }

    .button--green {
      outline: none;
      background-color: #64d18a;
      border-color: #64d18a;
      color: white;
      transition: all 200ms ease;
    }

    .button--green:hover {
      background-color: #8bdda8;
      color: white;
    }
  </style>

</head>

<body>
  <script src="https://js.braintreegateway.com/web/dropin/1.33.4/js/dropin.js"></script>

  <div id="dropin-container"></div>
  <button id="submit-button" class="button button--small button--green">Purchase</button>
  <script>
    var button = document.querySelector('#submit-button');

    braintree.dropin.create({
      authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
      selector: '#dropin-container'
    }, function(err, instance) {
      button.addEventListener('click', function() {
        instance.requestPaymentMethod(function(err, payload) {
          // Submit payload.nonce to your server
        });
      })
    });
  </script>
</body>

</html>