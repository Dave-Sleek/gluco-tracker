<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscribe to GlucoTracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- <script src="https://js.paystack.co/v1/inline.js"></script> -->
</head>
<style>
  .plan-card {
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
  }

  .plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }

  .plan-card.selected {
    border: 2px solid #007bff;
    box-shadow: 0 0 0 4px rgba(0,123,255,0.2);
  }

  .plan-card input[type="radio"] {
    display: none;
  }
</style>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-center mb-4">Choose Your Plan</h2>
  <form id="paymentForm">
    <div class="row justify-content-center">
      
      <!-- Monthly Plan -->
      <div class="col-md-4">
        <label class="card text-center shadow-sm plan-card">
          <div class="card-header bg-primary text-white">Monthly</div>
          <div class="card-body">
            <h3 class="card-title">₦3,000 / $5</h3>
            <p class="card-text">
                <i class="bi bi-calendar2-week text-primary me-2"></i>
                Get full access for 30 days. Ideal for trying things out or short-term tracking.
              </p>
            <input type="radio" name="plan" value="monthly" required>
          </div>
        </label>
      </div>

      <!-- Annual Plan -->
      <div class="col-md-4">
        <label class="card text-center shadow-sm plan-card">
          <div class="card-header bg-success text-white">Annual</div>
          <div class="card-body">
            <h3 class="card-title">₦30,000 / $50</h3>
            <p class="card-text">
              <i class="bi bi-calendar-check text-success me-2"></i>
              One full year of premium tracking, reminders, and insights. Save big vs. monthly.
            </p>
            <input type="radio" name="plan" value="annual" required>
          </div>
        </label>
      </div>

      <!-- Lifetime Plan -->
      <div class="col-md-4">
        <label class="card text-center shadow-sm plan-card">
          <div class="card-header bg-dark text-white">Lifetime</div>
          <div class="card-body">
            <h3 class="card-title">₦75,000 / $100</h3>
            <p class="card-text">
              <i class="bi bi-award text-dark me-2"></i>
              Pay once, enjoy forever. Lifetime access to all features and future upgrades.
            </p>
            <input type="radio" name="plan" value="lifetime" required>
          </div>
        </label>
      </div>
    </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-lg btn-primary">Pay Now</button>
    </div>
  </form>
</div>

<!-- Paystack Script -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
document.getElementById('paymentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const selectedPlan = document.querySelector('input[name="plan"]:checked').value;

    const plans = {
        monthly: 300000,
        annual: 3000000,
        lifetime: 7500000
    };

    const amount = plans[selectedPlan];

    let handler = PaystackPop.setup({
        key: "{{ $paystackKey }}",
        email: "{{ $email }}",
        amount: amount,
        currency: 'NGN',
        metadata: {
            user_id: {{ Auth::id() }},
            plan: selectedPlan
        },
        callback: function(response) {
            window.location.href = "{{ route('payment.verify') }}?reference=" + encodeURIComponent(response.reference);
        },
        onClose: function() {
            alert('Transaction cancelled.');
        }
    });

    handler.openIframe();
});
</script>

<script>
document.querySelectorAll('.plan-card').forEach(card => {
  card.addEventListener('click', () => {
    document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    const input = card.querySelector('input[type="radio"]');
    if (input) input.checked = true;
  });
});
</script>
</body>
</html>
