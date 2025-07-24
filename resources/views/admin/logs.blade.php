<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Logs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>📜 User Activity Logs</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>IP Address</th>
                    <th>Device</th>
                    <th>Location</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->user->full_name ?? '—' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->ip_address }}</td>
                        <td>{{ $log->user_agent }}</td>
                         <td>{{ $log->location }}</td>
                        <td>{{ $log->timestamp }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
        {{ $logs->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
</body>
</html>