<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Stripe Payment</h2>
        @if (session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif
        @if (session('error_message'))
            <div class="alert alert-danger">
                {{ session('error_message') }}
            </div>
        @endif
        <form id="payment-form">
            @csrf
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" class="form-control" id="amount" required>
            </div>
            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Payment</button>
        </form>
    </div>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        var card = elements.create('card', {style: style});
        card.mount('#card-element');
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });
        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</body>
</html>
