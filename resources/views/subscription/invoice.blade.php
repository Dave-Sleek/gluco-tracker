<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .invoice-card {
            max-width: 700px;
            margin: 3rem auto;
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.04);
        }

        .logo {
            max-width: 120px;
            margin-bottom: 1rem;
        }

        .title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-label {
            font-weight: 600;
            color: #343a40;
        }

        .info-value {
            color: #495057;
        }
    </style>
</head>
<body>
    <div class="invoice-card text-dark">
        <div class="text-center">
            <img src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}" alt="GlucoTracker Logo" class="logo">
            <h2 class="title">🧾 Subscription Invoice</h2>
        </div>

        <hr class="mb-4">

        <div class="mb-3">
            <p><span class="info-label">Name:</span> <span class="info-value">{{ $user->full_name }}</span></p>
            <p><span class="info-label">Email:</span> <span class="info-value">{{ $user->email }}</span></p>
        </div>

        <div class="mb-3">
            <p><span class="info-label">Plan:</span> <span class="info-value">{{ ucfirst($plan) }}</span></p>
            <p><span class="info-label">Amount Paid:</span> <span class="info-value">₦{{ number_format($amount, 2) }}</span></p>
            <p><span class="info-label">Reference:</span> <span class="info-value">{{ $reference }}</span></p>
            <p><span class="info-label">Date Issued:</span> <span class="info-value">{{ $date }}</span></p>
            <a href="{{ route('invoice.download', $reference) }}" class="btn btn-primary mt-3">
                <i class="bi bi-download"></i> Download PDF
            </a>
        </div>

        <hr class="mt-4">

        <p class="text-muted">Need help or have questions about your subscription? Reach out to our support team at any time.</p>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
