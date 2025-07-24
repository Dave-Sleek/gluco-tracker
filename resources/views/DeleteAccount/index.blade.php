<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<form method="POST" action="{{ route('account.destroy') }}"
      onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Yes, Delete My Account</button>
</form>

</body>
</html>