<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subscription Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 14px;
            color: #212529;
            padding: 40px;
            background-color: #f8f9fa;
        }
        .invoice-wrapper {
            background: #fff;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #0d6efd;
        }
        .logo {
            height: 50px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 20px;
        }
        .label {
            font-weight: 600;
            color: #495057;
        }
        .value {
            color: #212529;
        }
        hr {
            border-top: 1px solid #ced4da;
            margin: 30px 0;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #6c757d;
        }
    </style>
    @php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

<div class="invoice-wrapper">
        <div class="header">
            <img src="{{ public_path('frontend/assets/img/logo-icon-GT.png') }}" alt="GlucoTracker Logo" class="logo">
            <h1> <i class="fa fa-file"></i> Subscription Invoice</h1>
        </div>

        <div class="section">
            <p><span class="label">Name:</span> <span class="value">{{ $user->full_name }}</span></p>
            <p><span class="label">Email:</span> <span class="value">{{ $user->email }}</span></p>
        </div>

        <div class="section">
            <p><span class="label">Plan:</span> <span class="value">{{ ucfirst($plan) }}</span></p>
            <p><span class="label">Amount Paid:</span> <span class="value">N{{ number_format($amount, 2) }}</span></p>
            <p><span class="label">Reference:</span> <span class="value">{{ $reference }}</span></p>
            <p><span class="label">Date Issued:</span> <span class="value">{{ $date }}</span></p>
        </div>
        @if(isset($qrImage))
            <div style="text-align: center; margin-top: 30px;">
                <p style="font-weight: bold;">Scan to view your invoice:</p>
                <img src="{{ $qrImage }}" alt="QR Code" style="height: 150px;">
            </div>
        @endif


        <hr>

        <div class="footer">
            Thank you for choosing GlucoTracker.<br>
            Need help? Contact our support team anytime.
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
