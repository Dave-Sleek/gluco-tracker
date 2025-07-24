<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Renew Subscription</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow rounded">
        <div class="card-body text-center">
          <h3 class="card-title mb-3">Renew Your Subscription</h3>
          <p class="text-muted">Continue enjoying full access to your health dashboard.</p>

          <button class="btn btn-success btn-lg" onclick="payWithPaystack()">Pay ₦{{ number_format($amount / 100) }} Now</button>

          <p class="mt-3 text-muted">One-month access, billed monthly.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
// function payWithPaystack() {
//     var handler = PaystackPop.setup({
//         key: "{{ $paystackKey }}",
//         email: "{{ Auth::user()->email }}",
//         amount: {{ $amount }},
//         currency: 'NGN',
//         metadata: {
//             user_id: {{ Auth::id() }},
//             plan: 'monthly'
//         },
//         callback: function(response) {
//             window.location.href = "{{ route('payment.verify') }}?reference=" + encodeURIComponent(response.reference);
//         },
//         onClose: function() {
//             alert('Payment cancelled.');
//         }
//     });
//     handler.openIframe();
// }
</script>
<script>
function payWithPaystack() {
let handler = PaystackPop.setup({
    key: "{{ $paystackKey }}",
    email: "{{ $email }}",
    amount: {{ $amount }},
    currency: 'NGN',
    metadata: {
        user_id: {{ Auth::id() }},
        plan: 'monthly'
    },
    callback: function(response) {
        window.location.href = "{{ $callbackUrl }}?reference=" + encodeURIComponent(response.reference);
    },
    onClose: function() {
        alert('Payment cancelled.');
    }
});
handler.openIframe();
}
</script>
</body>
</html>
