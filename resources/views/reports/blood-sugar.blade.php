<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2, h4 { text-align: center; margin-bottom: 5px; }
        .user-info { text-align: center; margin-bottom: 20px; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>

<h2>Blood Sugar Report</h2>
<div class="user-info">
    <strong>{{ $user->full_name }}</strong><br>
    <em>{{ $user->email }}</em><br>
    Generated on: {{ now()->format('Y-m-d H:i') }}
</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Value</th>
            <th>Unit</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($readings as $row)
            <tr>
            <td>{{ \Carbon\Carbon::parse($row->converted_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $row->original_value }}</td>
                <td>{{ $row->original_unit }}</td>
                <td>{{ ucfirst($row->type) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
