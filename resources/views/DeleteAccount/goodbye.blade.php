<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Deleted</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      text-align: center;
    }
    .goodbye-box {
      background: white;
      padding: 3rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .emoji {
      font-size: 4rem;
    }
  </style>
</head>
<body>
<div class="goodbye-box">
  <div class="emoji mb-3">👋</div>
  <h2>Goodbye!</h2>
  <p>Your account has been successfully deleted.</p>

  <a href="{{ url('/') }}" class="btn btn-primary mt-3">Return to Home</a><br>
</div>
</body>
</html>
