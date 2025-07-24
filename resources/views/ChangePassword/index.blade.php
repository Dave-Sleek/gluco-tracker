
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow mx-auto" style="max-width: 500px;">
    <div class="card-header bg-primary text-white text-center">
      <h4>Change Password</h4>
    </div>

    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form method="POST">
        @csrf

        <div class="mb-3">
          <label for="current_password" class="form-label">Current Password</label>
          <input type="password" name="current_password" class="form-control" id="current_password" required>
        </div>

        <div class="mb-3">
          <label for="new_password" class="form-label">New Password</label>
          <input type="password" name="new_password" class="form-control" id="new_password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Update Password</button>
        <a href="{{ route('Profile') }}" class="btn btn-secondary mt-3 w-100">Back to Profile</a>
      </form>
    </div>
  </div>
</div>
</body>
</html>
