<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Subscription Overview</h3>

    <form class="row g-2 mb-3" method="GET">
        <div class="col-md-2">
            <select name="plan" class="form-select">
                <option value="">All Plans</option>
                @foreach (['monthly', 'annual', 'lifetime'] as $p)
                    <option value="{{ $p }}" {{ request('plan') == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                @foreach (['active', 'expired'] as $s)
                    <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="alert alert-info">Total Revenue: ₦{{ number_format($revenue) }}</div>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by name or email...">

    <table class="table table-bordered table-hover table-dark" id="subscriptionTable">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Plan</th>
            <th>Amount Paid</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $s)
                <tr>
                    <td>{{ $s->user->full_name }}</td>
                    <td>{{ $s->user->email }}</td>
                    <td>{{ ucfirst($s->plan) }}</td>
                    <td>{{ ucfirst($s->amount_paid) }}</td>
                    <td>{{ $s->start_date }}</td>
                    <td>{{ $s->end_date }}</td>
                    <td>{{ ucfirst($s->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($subscriptions->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($subscriptions->onFirstPage())
                <li class="page-item disabled"><span class="page-link">‹</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $subscriptions->previousPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">‹</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($subscriptions->getUrlRange(1, $subscriptions->lastPage()) as $page => $url)
                <li class="page-item {{ $subscriptions->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">{{ $page }}</a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            @if ($subscriptions->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $subscriptions->nextPageUrl() }}{{ request()->getQueryString() ? '&' . http_build_query(request()->except('page')) : '' }}">›</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">›</span></li>
            @endif
        </ul>
    </nav>
@endif


    {{ $subscriptions->links() }}

    <form method="POST" action="{{ route('admin.subscription.export') }}">
        @csrf
        <input type="hidden" name="plan" value="{{ request('plan') }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <input type="hidden" name="from_date" value="{{ request('from_date') }}">
        <input type="hidden" name="to_date" value="{{ request('to_date') }}">
        <button type="submit" class="btn btn-success">Export CSV</button>
    </form>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const term = this.value.toLowerCase();
    document.querySelectorAll('#subscriptionTable tbody tr').forEach(row => {
        const name = row.cells[0].innerText.toLowerCase();
        const email = row.cells[1].innerText.toLowerCase();
        row.style.display = name.includes(term) || email.includes(term) ? '' : 'none';
    });
});
</script>
</body>
</html>

