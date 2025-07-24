<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subscription Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0">
        <div class="card-body">
          <h3 class="card-title text-center mb-4">📅 Subscription Details</h3>

          @if($subscription)
            <ul class="list-group mb-3">
              <li class="list-group-item"><strong>Plan:</strong> {{ ucfirst($subscription->plan) }}</li>
              <li class="list-group-item"><strong>Amount:</strong> &#8358;{{ ucfirst($subscription->amount_paid) }}</li>
              <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($subscription->status) }}</li>
              <li class="list-group-item"><strong>Start Date:</strong> {{ $subscription->start_date }}</li>
              <li class="list-group-item"><strong>End Date:</strong> {{ $subscription->end_date }}</li>
              <li class="list-group-item">@if($subscription->payment_reference)
                    <a href="{{ route('subscription.invoice', ['reference' => $subscription->payment_reference]) }}" class="btn btn-outline-primary">
                        View Invoice
                    </a>
                @else
                    <span class="text-muted">Invoice not available</span>
                @endif
                </li>
                </ul>

            @if($subscription->end_date < now()->toDateString())
              <div class="alert alert-warning text-center">
                Your subscription has expired.
                <a href="{{ route('subscription.renew') }}" class="btn btn-primary btn-sm ms-2">Renew Now</a>
              </div>
            @endif

          @else
            <div class="alert alert-info text-center">
              You have no active subscription.
              <a href="{{ route('payment.subscribe') }}" class="btn btn-success btn-sm ms-2">Subscribe Now</a>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
