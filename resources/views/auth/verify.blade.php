<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Verify Your Email Address</h5>
                    </div>

                    <div class="card-body">

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success mb-3">
                                A new verification link has been sent to your email address.
                            </div>
                        @endif

                        <p class="mb-3">
                            Thanks for signing up! To continue, please verify your email address by clicking the link
                            we've sent to your inbox.
                        </p>

                        <p class="mb-3 text-muted">
                            If you didn’t receive the email, click the button below and we’ll send you another.
                        </p>

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Resend Verification Email
                            </button>
                        </form>

                        <hr class="my-4">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                Log Out
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
