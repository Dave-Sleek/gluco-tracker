<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">User Profile</h3>
            <p><strong>Name:</strong> {{ $user->full_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
        </div>
    </div>

    <div class="card shadow mt-4">
        <div class="card-body">
            <h4 class="card-title">Blood Sugar Conversions</h4>

            @if ($conversions->count())
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Original</th>
                                <th>Converted</th>
                                <th>Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conversions as $c)
                                <tr>
                                    <td>{{ $c->original_value }} {{ $c->original_unit }}</td>
                                    <td>{{ $c->converted_value }} {{ $c->converted_unit }}</td>
                                    <td>{{ ucfirst($c->type) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($c->converted_at)->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4">Conversion Chart</h5>
                <canvas id="chart" height="100"></canvas>
            @else
                <p class="text-muted mt-3">No blood sugar readings found for this user.</p>
            @endif
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-outline-primary" onclick="downloadCSV()">Download CSV</button>
        <button class="btn btn-outline-danger" onclick="downloadPDF()">Download PDF</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script>
function downloadCSV() {
    const rows = [
        ["Original", "Converted", "Type", "Date"],
        ...@json($csvData)
    ];

    // const csvContent = "data:text/csv;charset=utf-8," +
    //     rows.map(row => row.map(cell => `"${cell}"`).join(",")).join("\n");

    const escape = value => `"${String(value).replace(/"/g, '""')}"`;
    const csvContent = "data:text/csv;charset=utf-8," +
    rows.map(row => row.map(escape).join(",")).join("\n");


    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "user_conversions.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(14);
    doc.text("User Blood Sugar Conversions", 14, 15);

    const chartCanvas = document.getElementById("chart");
    const chartImage = chartCanvas.toDataURL("image/png", 1.0);
    doc.addImage(chartImage, "PNG", 15, 25, 180, 80);

    const headers = [["Original", "Converted", "Type", "Date"]];
    const data = @json($csvData);

    doc.autoTable({
        startY: 110,
        head: headers,
        body: data,
        theme: 'grid'
    });

    doc.save("user_conversions.pdf");
}
</script>
<script>
const ctx = document.getElementById('chart').getContext('2d');
const chartData = {
    labels: @json($conversions->pluck('converted_at')),
    datasets: [{
        label: 'Original Value ({{ $conversions[0]->original_unit ?? '' }})',
        data: @json($conversions->pluck('original_value')),
        borderColor: '#007bff',
        backgroundColor: 'rgba(0, 123, 255, 0.1)',
        tension: 0.3
    }]
};

new Chart(ctx, {
    type: 'line',
    data: chartData,
    options: {
        scales: {
            x: { title: { display: true, text: 'Date' } },
            y: { title: { display: true, text: 'Blood Sugar' }, beginAtZero: true }
        }
    }
});
</script>

</body>
</html>


