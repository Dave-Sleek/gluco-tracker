<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Stats</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold display-6 text-dark">
                📊 Admin Overview <span class="text-muted small">— Latest stats</span>
            </h2>
            <p class="text-muted">Performance insights and total activity breakdown</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card shadow-sm border-0 text-center p-4 bg-light">
                    <h6 class="text-primary">
                        <i class="bi bi-people-fill me-2"></i>Total Users
                    </h6>
                    <h2 class="fw-bold text-dark">{{ $total_users }}</h2>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 text-center p-4 bg-light">
                    <h6 class="text-success">
                        <i class="bi bi-bell-fill me-2"></i>Total Reminders
                    </h6>
                    <h2 class="fw-bold text-dark">{{ $total_reminders }}</h2>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 text-center p-4 bg-light">
                    <h6 class="text-danger">
                        <i class="bi bi-droplet-half me-2"></i>Blood Sugar Logs
                    </h6>
                    <h2 class="fw-bold text-dark">{{ $total_logs }}</h2>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-sm border-0 text-center p-4 bg-light">
                    <h6 class="text-warning">
                        <i class="bi bi-basket-fill me-2"></i>Meals Added
                    </h6>
                    <h2 class="fw-bold text-dark">{{ $total_meals }}</h2>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
