<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-card {
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .admin-card:hover {
            transform: scale(1.02);
        }

        .admin-section {
            margin-top: 40px;
        }
    </style>
</head>
@php
    use Illuminate\Support\Facades\Auth;

    if (!Auth::check()) {
        header('Location: ' . route('login'));
        exit();
    }

    if (!Auth::user()->is_admin) {
        echo '⛔ Access Denied. Admins only.';
        exit();
    }
@endphp

<body>
    <div class="container py-5">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}"></a>
        <h2 class="text-center mb-5">Admin Panel</h2>
        <div class="row g-4">

            @php
                $cards = [
                    [
                        'icon' => '📊',
                        'title' => 'View Stats',
                        'desc' => 'Check system-wide usage metrics and charts.',
                        'route' => 'admin.stats',
                    ],
                    [
                        'icon' => '👥',
                        'title' => 'Manage Users',
                        'desc' => 'Ban users, reset passwords, or view their data.',
                        'route' => 'admin.users',
                    ],
                    [
                        'icon' => '🍽️',
                        'title' => 'Manage Meals',
                        'desc' => 'Add, edit, or remove meals from the app.',
                        'route' => 'admin.meals.manage',
                    ], // ← New card
                    [
                        'icon' => '',
                        'title' => 'Subscriptions & Payment',
                        'desc' => 'Manage all users Subscriptions & Payment',
                        'route' => 'admin.subscriptions',
                    ],
                    [
                        'icon' => '📬',
                        'title' => 'Feedback & Issues',
                        'desc' => 'Review submitted feedback, disputes, and bug reports.',
                        'route' => 'admin.feedback',
                    ],
                    [
                        'icon' => '✉️',
                        'title' => 'Admin Messaging',
                        'desc' => 'Send announcements or direct messages to users.',
                        'route' => 'admin.messages',
                    ],
                    [
                        'icon' => '📜',
                        'title' => 'User Logs',
                        'desc' => 'Track user activity logs and history.',
                        'route' => 'admin.logs',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-6 col-lg-4">
                    <div class="card admin-card p-4">
                        <h5 class="card-title">{{ $card['icon'] }} {{ $card['title'] }}</h5>
                        <p class="card-text">{{ $card['desc'] }}</p>
                        <a href="{{ route($card['route']) }}" class="btn btn-primary">Go</a>
                    </div>
                </div>
            @endforeach

            <a href="#" class="btn btn-outline-primary btn-sm"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>

</html>
