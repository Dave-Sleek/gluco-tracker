
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Doctor Reports</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    @if ($authorized ?? false)
        <h2>✅ Authorized Report for {{ $user->full_name }}</h2>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Blood Sugar (mg/dL)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($readings as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->converted_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ $row->original_value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h2>🔐 Enter Password to View Report</h2>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first('password') }}</div>
        @endif

        <form method="POST" action="{{ route('reports.view', ['token' => $token]) }}">
            @csrf
            <input type="password" name="password" class="form-control my-2" placeholder="Enter password" required>
            <button type="submit" class="btn btn-primary">View Report</button>
        </form>
    @endif
</div>
</body>
</html>
