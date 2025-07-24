<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <script>
        const csrfToken = '{{ csrf_token() }}';
    </script> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json" crossorigin="use-credentials">
    <title>Blood Sugar Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <script src="https://www.gstatic.com/firebasejs/11.10.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/11.10.0/firebase-messaging-compat.js"></script> -->
    <!-- <script>
        const csrfToken = '{{ csrf_token() }}';
    </script>
    <script src="{{ url('frontend/assets/js/push.js') }}"></script> -->

    @auth
        <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
        <script>
            window.OneSignalDeferred = window.OneSignalDeferred || [];

            OneSignalDeferred.push(async function(OneSignal) {
                try {
                    const oneSignalClient = await OneSignal.init({
                        appId: "2dc0dd7e-11c7-4474-8396-76985c918299", // your actual app ID
                        allowLocalhostAsSecureOrigin: true, // uncomment if testing locally with http://
                        notifyButton: {
                            enable: true
                        } // shows bell icon for subscription
                    });

                    console.log("✅ OneSignal initialized successfully");

                } catch (err) {
                    console.error("🚨 OneSignal init error:", err);
                }
            });
        </script>
    @endauth


    <style>
        .card-value {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 0.5em 0.75em;
        }

        .chart-container {
            height: 300px;
            position: relative;
        }

        .bg-custom-primary {
            background-color: #e3f2fd;
        }

        .bg-custom-secondary {
            background-color: #e3f7fa;
        }

        #installBtn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            display: none;
        }

        .condition-low {
            background-color: #ffcccc;
        }

        .condition-normal {
            background-color: #ccffcc;
        }

        .condition-high {
            background-color: #ffebcc;
        }

        .converter-box {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        #Convertedresult {
            border: 1px solid #ccc;
            background: #f9f9f9;
        }

        @keyframes pulse-up {
            0% {
                transform: translateY(0);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }

            50% {
                transform: translateY(-6px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            }

            100% {
                transform: translateY(0);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            }
        }

        .floating-btn {
            position: fixed;
            bottom: 60px;
            /* Elevated above footer */
            right: 20px;
            z-index: 999;
            padding: 10px 16px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: pulse-up 2.5s infinite;
            transition: background-color 0.3s ease;
        }

        .floating-btn:hover {
            background-color: #0c6dfd;
            /* Slightly darker blue on hover */
        }

        .floating-btn i {
            margin-right: 8px;
        }
    </style>
    <style>
        /* Global */
        body.dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0;
        }

        /* Navbar */
        .dark-mode .navbar,
        .dark-mode .offcanvas,
        .dark-mode .dropdown-menu {
            background-color: #1c1c1c !important;
            color: #ffffff !important;
            border-color: #2c2c2c;
        }

        /* Cards */
        .dark-mode .card,
        .dark-mode .card-body,
        .dark-modr .card-header,
        .dark-mode .modal-content,
        .dark-mode .alert {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
            border-color: #333;
        }

        /* Text */
        .dark-mode h1,
        .dark-mode h2,
        .dark-mode h3,
        .dark-mode h4,
        .dark-mode h5,
        .dark-mode h6,
        .dark-mode p,
        .dark-mode a,
        .dark-mode ul,
        .dark-mode li,

        .dark-mode small,
        .dark-mode label {
            color: #e0e0e0 !important;
        }


        /* Forms */
        .dark-mode .form-control,
        .dark-mode .form-select,
        .dark-mode input,
        .dark-mode select,
        .dark-mode .list-group,
        .dark-mode .list-group-item,
        .dark-mode textarea {
            background-color: #2b2b2b;
            color: #ffffff;
            border-color: #444;
        }

        /* Buttons */
        .dark-mode .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
        }

        .dark-mode .btn,
        .dark-mode .btn-close {
            color: #ffffff;
        }

        /* Table */
        .dark-mode table,
        .dark-mode th,
        .dark-mode td {
            background-color: #1e1e1e;
            color: #ffffff;
            border-color: #444;
        }

        /* Bootstrap Modal Backdrop */
        .dark-mode .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .bell-active {
            animation: ring 0.7s ease;
        }

        @keyframes ring {
            0% {
                transform: rotate(0);
            }

            25% {
                transform: rotate(15deg);
            }

            50% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }

            100% {
                transform: rotate(0);
            }
        }

        .chevron-icon {
            transition: transform 0.3s ease;
        }

        .chevron-icon.rotate {
            transform: rotate(180deg);
        }
    </style>

    <!-- ✅ Styled Add to Home Screen Button -->
    <style>
        #installPrompt,
        #iosInstallTip,
        #androidInstallTip {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            display: none;
            transition: all 0.3s ease;
        }

        #installPrompt {
            background-color: #0d6efd;
            color: white;
        }

        #installPrompt:hover {
            background-color: #0b5ed7;
        }

        #iosInstallTip,
        #androidInstallTip {
            background-color: #f8f9fa;
            color: #333;
            font-size: 14px;
            border: 1px solid #ccc;
        }

        #iosInstallTip button,
        #androidInstallTip button {
            margin-left: 10px;
            background: none;
            border: none;
            font-size: 16px;
            color: #666;
            cursor: pointer;
        }

        /* 🔥 Fade Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        .fade-out {
            animation: fadeOut 0.6s ease forwards;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}"><img
                    src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <button class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#authModal">
                                Login / Register
                            </button>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('analytics') }}"><i class="fa fa-line-chart"></i>
                                Analytics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('doctor') }}"><i class="fa fa-user-md"></i> Dr. Report</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('advance_search') }}"><i class="fa fa-search"></i> Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Recommendations') }}"><i class="fa fa-thumbs-up"></i>
                                Recommendations</a>
                        </li>
                        <!-- <li class="nav-item">
                                                                                                                                                                                                            <a class="nav-link" href="{{ route('symptoms') }}"><i class="fa fa-smile"></i> Symptoms</a>
                                                                                                                                                                                                          </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subscription.details') }}"> <i
                                    class="fa fa-credit-card-alt"></i> Subscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('Profile') }}">
                                <i class="fa fa-gear"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('support.show') }}">
                                <i class="fa fa-question-circle"></i> Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <!-- <a class="btn btn-outline-primary btn-sm" href="{{ route('logout') }}">
                                                                                                                                                                                                              <i class="fa fa-sign-out"></i> Logout
                                                                                                                                                                                                            </a> -->
                            <a href="#" class="btn btn-outline-primary btn-sm"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">

        <div class="row">
            <div class="col-12 col-md-6 col-lg-5 mx-auto">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <h6 class="mb-0">📢 Subscription & Notifications </h6>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse"
                            data-bs-target="#subscriptionCard">
                            Toggle
                        </button>
                    </div>

                    <div class="collapse show" id="subscriptionCard">
                        <div class="card-body">

                            <!-- Notifications -->
                            @foreach (auth()->user()->notifications as $notification)
                                @if (isset($notification->data['message']))
                                    <div class="alert alert-info py-1 px-2 mb-2">
                                        {{ $notification->data['message'] }}
                                    </div>
                                @endif
                            @endforeach

                            <!-- Subscription Info -->
                            @if (isset($invoice) && isset($invoice->plan))
                                <p class="mb-1">Plan: <strong>{{ ucfirst($invoice->plan) }}</strong></p>

                                @if (is_null($invoice->end_date))
                                    <p class="text-info mb-1">Your plan is lifetime — no expiry.</p>
                                @elseif(is_int($subscriptionCountdown))
                                    @if ($subscriptionCountdown > 0)
                                        <p class="text-success mb-1">Expires in <strong>{{ $subscriptionCountdown }}
                                                day{{ $subscriptionCountdown > 1 ? 's' : '' }}</strong></p>
                                    @elseif($subscriptionCountdown === 0)
                                        <p class="text-warning mb-1">Your subscription expires today.</p>
                                    @else
                                        <p class="text-danger mb-1">Expired <strong>{{ abs($subscriptionCountdown) }}
                                                day{{ abs($subscriptionCountdown) > 1 ? 's' : '' }}</strong> ago</p>
                                    @endif
                                @else
                                    <p class="text-muted mb-1">Unable to calculate expiry for this subscription.</p>
                                @endif

                                <!-- Progress Bar with animation -->
                                @php
                                    $start = \Carbon\Carbon::parse($invoice->start_date);
                                    $end = \Carbon\Carbon::parse($invoice->end_date);
                                    $totalDuration = $start->diffInDays($end);
                                    $usedDuration = $start->diffInDays(now());
                                    $percentUsed =
                                        $totalDuration > 0
                                            ? min(100, round(($usedDuration / $totalDuration) * 100))
                                            : 100;
                                    $percentRemaining = 100 - $percentUsed;
                                @endphp

                                <div class="progress mt-2" style="height: 16px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width: {{ $percentRemaining }}%;"
                                        aria-valuenow="{{ $percentRemaining }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                        {{ $percentRemaining }}% Remaining
                                    </div>
                                </div>

                                <!-- Status Badge -->
                                <div class="mt-2">
                                    @if (is_null($invoice->end_date))
                                        <span class="badge bg-info"><i class="bi bi-check-circle"></i> Lifetime</span>
                                    @elseif($subscriptionCountdown > 7)
                                        <span class="badge bg-success"><i class="bi bi-check-circle"></i>
                                            Active</span>
                                    @elseif($subscriptionCountdown >= 1 && $subscriptionCountdown <= 7)
                                        <span class="badge bg-warning text-dark">⏰ Expiring Soon</span>
                                    @elseif($subscriptionCountdown === 0)
                                        <span class="badge bg-orange text-white">⏳ Expires Today</span>
                                    @else
                                        <span class="badge bg-danger">❌ Expired</span>
                                    @endif
                                </div>

                                <!-- Renew Button -->
                                @if ($subscriptionCountdown <= 0 && !is_null($invoice->end_date))
                                    <a href="{{ route('payment.subscribe') }}" class="btn btn-sm btn-primary mt-2">
                                        🔁 Renew Now
                                    </a>
                                @endif
                            @else
                                <p class="mb-0">No active subscription found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header -->
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted small mb-0">Welcome back, {{ Auth::user()->full_name }}!
                    @auth
                        @if (auth()->user()->hasVerifiedEmail())
                            <span class="badge bg-success"><i class="bi bi-patch-check-fill"></i> Verified</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Unverified</span>
                            <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning ms-2">
                                Verify Now
                            </a>
                        @endif
                    @endauth
                </p>
            </div>
            @if ($show_trial_banner && $days_left !== null)
                <div class="alert alert-warning text-center">
                    ⏳ Your free trial ends in {{ $days_left }} day{{ $days_left == 1 ? '' : 's' }} <a
                        href="{{ route('payment.subscribe') }}" class="btn btn-sm btn-success ms-2">Subscribe now</a>
                    to keep using the Gluco-Tracker.
                </div>
            @endif

            <div class="d-flex align-items-center">
                <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip"
                    title="Toggle Dark Mode">
                    <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
                </button>
                <a href="{{ route('notifications') }}" class="btn btn-md position-relative bell-active"
                    data-bs-toggle="tooltip" title="Notifications">
                    <i class="bi bi-bell fs-5"></i>
                    @if ($unread_count > 0)
                        <span class="position-absolute top-10 end-10 translate-middle badge rounded-pill bg-danger">
                            {{ $unread_count }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                </a>
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" width="50px"
                    class="rounded-circle border border-2 border-primary">
            </div>
        </header>

        @if (session('status') === 'reading_added')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> New reading added successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- More content continues below -->


        <!-- Quick Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card bg-custom-primary border-0 h-100">
                    <div class="card-body">
                        <div class="mt-3" id="currentLevelDisplay"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted small fw-bold">7-Day Average</h6>
                        <p class="card-value text-secondary mb-1" id="avg7Display">
                            {{ isset($avg_reading['avg_value']) ? round($avg_reading['avg_value'], 1) : '--' }}
                            <span class="fs-6">mg/dL</span>
                        </p>
                        <div class="mt-2">
                            <span id="trendText" class="text-muted small">
                                <i class="bi bi-dash"></i> --
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-custom-secondary border-0 h-100">
                    <div class="card-body">
                        <h5 class="text-uppercase text-muted small fw-bold"><i class="bi bi-bullseye me-2"></i> Target
                            Range For Non Diabetic</h5>
                        <p id="latestReadingStatus" class="mt-3"></p>
                        <div class="mt-2">
                            <small class="text-muted">
                                <span class="badge bg-success">Fasting: 70–99 mg/dL</span>
                                <span class="badge bg-warning text-dark">After Meal: 140–180 mg/dL</span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Content -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Chart -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between">
                        <h5 class="mb-0">Weekly Trend</h5>
                        <select class="form-select form-select-sm w-auto" id="timePeriodSelect">
                            <option value="7">This Week</option>
                            <option value="14">Last 2 Weeks</option>
                            <option value="30">Last 30 Days</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="bloodSugarChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Smart Recommendations -->
                <br>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-lightbulb me-2"></i>Smart Recommendations</h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($recommendations as $tip)
                                <li class="list-group-item">
                                    {!! $tip !!}
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <br />

                <!-- Meal Logs Card -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <i class="bi bi-file-text"></i> Your Meal History
                        <button class="btn btn-sm btn-light d-flex align-items-center gap-1" type="button"
                            data-bs-toggle="collapse" data-bs-target="#mealHistoryCollapse" aria-expanded="true"
                            aria-controls="mealHistoryCollapse" onclick="toggleChevron(this)">
                            <span>Toggle</span>
                            <i class="bi bi-chevron-down transition chevron-icon"></i>
                        </button>
                    </div>

                    <div class="collapse show" id="mealHistoryCollapse">
                        <div class="card-body">
                            @forelse ($mealLogs as $meal)
                                <div class="border p-2 mb-3 rounded">
                                    <strong>{{ $meal->meal_description }}</strong><br>
                                    <span class="text-muted">{{ $meal->logged_at->diffForHumans() }}</span><br>

                                    @foreach ($meal->tags ?? [] as $tag)
                                        <span class="badge bg-info">{{ $tag }}</span>
                                    @endforeach

                                    @if ($meal->glucose)
                                        <span class="badge bg-warning mt-2">
                                            Glucose
                                            ({{ \Carbon\Carbon::parse($meal->glucose->converted_at)->format('F j • g:iA') }})
                                            :
                                            {{ $meal->glucose->original_value }} {{ $meal->glucose->original_unit }}
                                        </span>
                                    @endif

                                    @if (isset($meal->recommendation))
                                        <div class="mt-2 alert alert-info small">
                                            💡 {{ $meal->recommendation }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted">No meals logged yet. Once you do, recommendations will appear
                                    here.</p>
                            @endforelse

                            <div class="text-end mb-3">
                                <a href="{{ route('meal-log.index') }}" class="btn btn-primary"><i class="bi bi-save"></i> Log a Meal</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Symptoms -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa fa-stethoscope"></i> Recent Symptom Logs</h5>

                        <button class="btn btn-sm btn-light d-flex align-items-center gap-1" type="button"
                            data-bs-toggle="collapse" data-bs-target="#symptomLogCollapse" aria-expanded="true"
                            aria-controls="symptomLogCollapse" onclick="toggleChevron(this)">
                            <span>Toggle</span>
                            <i class="bi bi-chevron-down transition chevron-icon"></i>
                        </button>
                    </div>

                    <div class="collapse show" id="symptomLogCollapse">
                        <div class="card-body">
                            @forelse ($logs as $log)
                                <div class="border p-2 mb-3 rounded bg-light">
                                    <strong>{{ $log->symptom }}</strong><br>
                                    <span
                                        class="text-muted">{{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}</span><br>

                                    @if ($log->notes)
                                        <small class="d-block">📝 {{ $log->notes }}</small>
                                    @endif

                                    @if ($log->glucose_before)
                                        <span class="badge bg-warning me-1">
                                            Before: {{ $log->glucose_before->original_value }}
                                            {{ $log->glucose_before->original_unit }}
                                        </span>
                                    @endif

                                    @if ($log->glucose_after)
                                        <span class="badge bg-info me-1">
                                            After: {{ $log->glucose_after->original_value }}
                                            {{ $log->glucose_after->original_unit }}
                                        </span>
                                    @endif

                                    @if (isset($log->correlation))
                                        <span class="badge bg-secondary">
                                            🧠 Correlation: {{ $log->correlation }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted">
                                    No symptom logs yet. Once you start logging, you'll see patterns here.
                                </p>
                            @endforelse

                            <div class="text-end mb-3">
                                <a href="{{ route('symptoms') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Add New Symptom
                                </a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Actions -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="dateSelect" class="form-label fw-bold">Select Date</label>
                            <input type="date" id="dateSelect" class="form-control"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal"
                            data-bs-target="#converterModal">
                            <i class="bi bi-plus-circle"></i> Add New Reading
                        </button>
                        <!-- Floating Add Reading Button -->
                        <button class="btn btn-primary floating-btn" data-bs-toggle="modal"
                            data-bs-target="#converterModal">
                            <i class="bi bi-plus-circle"></i> Add New Reading
                        </button>

                        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#remindarModal">
                            <i class="bi bi-alarm"></i> Set Reminder
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm  mb-3" style="min-width: 250px;">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">My Meal Plan Today</h5>
                    </div>
                    <div class="card-body p-2">
                        @forelse ($plannedMeals as $plan)
                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset($plan->meal->image_url) }}" alt="{{ $plan->meal->name }}"
                                    class="me-2 rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong>{{ $plan->meal->name }}</strong><br>
                                    <small>{{ $plan->meal->description }}</small><br>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($plan->scheduled_for)->format('M j') }}</small>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No meals scheduled yet.</p>
                        @endforelse

                        @if (Auth::user()->meal_preference === null)
                            <div class="alert alert-info">
                                Set your meal style to receive personalized suggestions:
                                @livewire('meal-preference')
                            </div>
                        @endif
                        <div class="mb-3">
                         <a href="{{ route('meal-suggestions') }}" class="btn btn-primary w-100"><i class="bi bi-grid"></i> View My Meal Suggestions</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Readings -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">Recent Readings</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($recent_readings as $reading)
                                @php
                                    $badge_class = match (true) {
                                        $reading['original_value'] < 70 => 'bg-danger',
                                        $reading['original_value'] <= 140 => 'bg-success',
                                        default => 'bg-warning text-dark',
                                    };
                                    $condition = match (true) {
                                        $reading['original_value'] < 70 => 'Low',
                                        $reading['original_value'] <= 140 => 'Normal',
                                        default => 'High',
                                    };
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <span class="badge bg-info me-2">
                                            {{ ucfirst(str_replace('-', ' ', $reading['type'])) }}
                                        </span>
                                        <strong>{{ $reading['original_value'] }}
                                            {{ $reading['original_unit'] }}</strong>
                                    </div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($reading['converted_at'])->format('M j, g:i A') }}
                                    </small>
                                </li>
                            @empty
                                <li class="list-group-item px-0 text-muted">No recent readings found</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <br>

                <!-- Recent Reminders -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0"><i class="bi bi-bell me-2"></i>Recent Reminders</h5>
                        </div>
                        @if ($reminders->isEmpty())
                            <p class="text-muted">No upcoming reminders.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($reminders as $r)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>{{ $r['subject'] }} <br>
                                            <small class="text-muted">Scheduled On:
                                                <i>{{ \Carbon\Carbon::parse($r['scheduled_time'])->format('M j, H:i') }}</i>
                                            </small>
                                        </strong>
                                        <span class="badge bg-primary rounded-pill">
                                            {{ \Carbon\Carbon::parse($r['created_at'])->format('M j, H:i') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- New Reading Modal -->
    <div class="modal fade" id="converterModal" tabindex="-1" aria-labelledby="converterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="newReadingModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Add New Reading
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="convertForm" method="POST" action="{{ route('blood.alert') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="value" class="form-label">Enter Value:</label>
                            <input type="number" step="any" class="form-control" id="value"
                                name="original_value" required>
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Select Unit:</label>
                            <select class="form-select" id="unit" name="original_unit" required>
                                <option value="mg/dL">mg/dL</option>
                                <option value="mmol/L">mmol/L</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Select Type:</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="fasting">Fasting</option>
                                <option value="after_meal">After Meal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Note (Morning, Afternoon, Evening or Before
                                Bed):</label>
                            <input type="text" class="form-control" id="label" name="label" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Reading</button>
                    </form>

                    <div id="Convertedresult" class="alert alert-info mt-4 d-none"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("convertForm").addEventListener("submit", function(e) {
            e.preventDefault();

            const value = parseFloat(document.getElementById("value").value);
            const unit = document.getElementById("unit").value;
            const type = document.getElementById("type").value;
            const label = document.getElementById("label").value;

            fetch("{{ route('convert') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        original_value: value,
                        original_unit: unit,
                        type: type,
                        label: label
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const resultDiv = document.getElementById("Convertedresult");
                    resultDiv.classList.remove("d-none", "alert-danger", "alert-success");

                    if (data.success) {
                        resultDiv.classList.add("alert-success");
                        resultDiv.innerHTML =
                            `${data.original_value} ${data.original_unit} = <strong>${data.converted_value} ${data.converted_unit}</strong> (${data.type.replace('_', ' ')})`;
                        updateLatestReading();
                        fetchChartData(document.getElementById("timePeriodSelect")?.value || 7);
                        fetchAverageData();
                    } else {
                        resultDiv.classList.add("alert-danger");
                        resultDiv.innerText = data.message || "Conversion failed.";
                    }
                })
                .catch(err => {
                    console.error("Error submitting conversion:", err);
                });
        });
    </script>


    <!-- Reminder Modal -->
    <div class="modal fade" id="remindarModal" tabindex="-1" aria-labelledby="remindarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('reminders.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="remindarModalLabel">Set a Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">Message</label>
                        <textarea class="form-control" name="body" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="recurrence" class="form-label">Recurrence</label>
                        <select name="recurrence" class="form-select" id="recurrenceSelect" required
                            onchange="toggleRecurrenceFields()">
                            <option value="none">One-Time</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="weeklyDay">
                        <label for="day_of_week" class="form-label">Day of Week</label>
                        <select name="day_of_week" class="form-select">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>

                    <div class="mb-3" id="timeField">
                        <label for="time_of_day" class="form-label">Time of Day</label>
                        <input type="time" name="time_of_day" class="form-control" value="08:00" required>
                    </div>

                    <div class="mb-3 d-none" id="dateField">
                        <label for="scheduled_time" class="form-label">Date</label>
                        <input type="datetime-local" name="scheduled_time" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Reminder</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include your modal (converterModal, remindarModal) here as Blade partials or directly in the same file -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chart;
        document.addEventListener("DOMContentLoaded", function() {
            fetchChartData(7); // Load initial data for "This Week"

            document.getElementById('timePeriodSelect').addEventListener('change', function() {
                const days = this.value;
                fetchChartData(days);
            });
        });

        function fetchChartData(days) {
            fetch("/chart-data?days=" + days)
                .then(response => response.json())
                .then(data => {
                    if (!data || !Array.isArray(data.labels) || data.labels.length === 0) {
                        displayNoDataMessage();
                    } else {
                        hideNoDataMessage(() => {
                            updateChart(data.labels, data.values);
                        });
                    }
                })
                .catch(error => {
                    console.error("Error fetching chart data:", error);
                    displayNoDataMessage();
                });
        }

        function displayNoDataMessage() {
            const container = document.querySelector('.chart-container');
            container.innerHTML = '<div class="text-center text-muted py-5">No data available for this period.</div>';
            if (chart) chart.destroy();
        }

        function hideNoDataMessage(callback) {
            const container = document.querySelector('.chart-container');
            container.innerHTML = '<canvas id="bloodSugarChart"></canvas>';
            // Wait for DOM update before drawing chart
            requestAnimationFrame(callback);
        }

        function updateChart(labels, values) {
            const ctx = document.getElementById('bloodSugarChart').getContext('2d');

            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Blood Sugar (mg/dL)',
                        data: values,
                        fill: false,
                        borderColor: '#007bff',
                        tension: 0.2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        }
    </script>

    <script>
        function fetchAverageData() {
            fetch("{{ route('average.7day') }}")
                .then(res => res.json())
                .then(data => {
                    const avg = data.avg_value !== null ? parseFloat(data.avg_value).toFixed(1) : '--';
                    document.getElementById("avg7Display").innerHTML = `${avg} <span class="fs-6">mg/dL</span>`;

                    const trendContainer = document.getElementById("trendText");
                    trendContainer.className = `${data.trend_class} small`;
                    trendContainer.innerHTML = `<i class="bi ${data.trend_icon}"></i> ${data.trend_text}`;
                })
                .catch(err => {
                    console.error("Failed to fetch 7-day average:", err);
                });
        }
        fetchAverageData()
    </script>

    <script>
        function updateLatestReading() {
            fetch("{{ route('reading.latest') }}")
                .then(res => res.json())
                .then(data => {
                    console.log("Latest reading response:", data);

                    const display = document.getElementById("currentLevelDisplay");

                    if (!data || !data.original_value) {
                        display.innerHTML = "<p class='text-muted'>No readings yet.</p>";
                        return;
                    }

                    const condition = data.condition_status || '';
                    let advisory = '';

                    switch (condition) {
                        case 'Low':
                            advisory =
                                '<i class="bi bi-exclamation-triangle"></i> Your blood sugar is low. Consider eating a fast-acting carb and monitoring symptoms.';
                            break;
                        case 'Target (Fasting)':
                        case 'Target (Post-Meal)':
                            advisory =
                                '<i class="bi bi-check-circle"></i> Your blood sugar is within the recommended range. Keep up your management routine!';
                            break;
                        case 'High':
                            advisory =
                                '<i class="bi bi-exclamation-triangle"></i> Blood sugar is elevated. Review your recent meals, activity, or medications.';
                            break;
                        case 'Very High':
                            advisory =
                                '<i class="fa-solid fa-light-emergency"></i> Your blood sugar is very high. Contact your healthcare provider if this continues.';
                            break;
                        default:
                            advisory =
                                'ℹ️ Blood sugar status unknown. Please double-check your entry or tracking schedule.';
                    }

                    const html = `
        <div class="mt-3">
          <div>
            <h6 class="text-uppercase text-muted small fw-bold">Current Level</h6>
            <p class="card-value text-primary mb-1">
              ${data.original_value} <span class="fs-6">${data.original_unit}</span>
            </p>
            <span class="badge ${condition.includes('Target') ? 'bg-success' : 'bg-warning'} status-badge">
            <i class="bi ${condition.includes('Target') ? 'bi-check-circle' : 'bi-exclamation-triangle'}"></i>
            ${condition || '--'}
            </span><br />
            <span class="fs-6">
            <span class="badge bg-success mt-1">Value in:</strong> ${data.converted_value} ${data.converted_unit}</span>
            </span>
            <br>
            <span class="badge bg-light text-dark mt-1">Timing: ${data.label}</span>
            <br>
            <small class="text-muted">${new Date(data.converted_at).toLocaleString()}</small>
            <br>
            <span class="text-info small mt-2 d-block"><i class="bi bi-info-circle"></i> ${advisory}</span>
            <div class="mt-3">
            <span class="badge bg-success">Fasting: 80–100 mg/dL</span>
            <span class="badge bg-warning text-dark">After Meal: 140–180 mg/dL</span>
            </div>
          </div>
        </div>
      `;

                    display.innerHTML = html;
                })
                .catch(err => {
                    console.error("Error loading latest reading:", err);
                });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            updateLatestReading();
        });
    </script>
    <script>
        function toggleRecurrenceFields() {
            const recurrence = document.getElementById('recurrenceSelect')?.value;
            const dayField = document.getElementById('weeklyDay');
            const timeField = document.getElementById('timeField');
            const dateField = document.getElementById('dateField');

            if (!recurrence || !dayField || !timeField || !dateField) return;

            switch (recurrence) {
                case 'weekly':
                    dayField.classList.remove('d-none');
                    timeField.classList.remove('d-none');
                    dateField.classList.add('d-none');
                    break;
                case 'daily':
                    dayField.classList.add('d-none');
                    timeField.classList.remove('d-none');
                    dateField.classList.add('d-none');
                    break;
                default:
                    dayField.classList.add('d-none');
                    timeField.classList.add('d-none');
                    dateField.classList.remove('d-none');
                    break;
            }
        }
    </script>
    <script>
        const latestValue = "{{ $latest->original_value ?? '' }}";
        const latestUnit = "{{ $latest->original_unit ?? '' }}";
        const latestLabel = "{{ $latest->label ?? '' }}"; // Morning, Afternoon, Evening, Before Bed
        let inRange = false;
        let borderline = false;
        let low = 0,
            high = 0;

        const readingNumeric = parseFloat(latestValue);
        const isNumeric = !isNaN(readingNumeric);

        if (isNumeric) {
            switch (latestUnit) {
                case 'mg/dL':
                    switch (latestLabel.toLowerCase()) {
                        case 'morning':
                            low = 70;
                            high = 99;
                            break;
                        case 'afternoon':
                            low = 70;
                            high = 180;
                            break;
                        case 'evening':
                            low = 80;
                            high = 140;
                            break;
                        case 'before bed':
                            low = 100;
                            high = 140;
                            break;
                        default:
                            low = 70;
                            high = 180;
                    }
                    break;

                case 'mmol/L':
                    switch (latestLabel.toLowerCase()) {
                        case 'morning':
                            low = 3.9;
                            high = 5.5;
                            break;
                        case 'afternoon':
                            low = 3.9;
                            high = 10.0;
                            break;
                        case 'evening':
                            low = 4.4;
                            high = 7.8;
                            break;
                        case 'before bed':
                            low = 5.5;
                            high = 7.8;
                            break;
                        default:
                            low = 3.9;
                            high = 10.0;
                    }
                    break;
            }

            inRange = readingNumeric >= low && readingNumeric <= high;

            // Borderline logic: within 1 mg/dL or 0.1 mmol/L of the upper limit
            const margin = latestUnit === 'mg/dL' ? 1 : 0.1;
            borderline = !inRange && Math.abs(readingNumeric - high) <= margin;
        }

        // Advisory message
        let advisoryMessage = 'Reading not available.';

        if (isNumeric) {
            if (inRange) {
                advisoryMessage =
                    '<i class="bi bi-check-circle"></i> Your blood sugar is within the ideal range for this time of day.';
            } else if (borderline) {
                advisoryMessage =
                    '<i class="bi bi-exclamation-circle"></i> Your reading is slightly above the ideal range. Keep monitoring — it may not be concerning if it’s occasional.';
            } else {
                advisoryMessage =
                    '<i class="bi bi-exclamation-triangle"></i> Your blood sugar is outside the recommended range. Consider reviewing your meals, activity, or medication.';
            }
        }

        const statusEl = document.getElementById("latestReadingStatus");
        statusEl.innerHTML = isNumeric ? `
    <p class="card-value text-secondary mb-1">
      ${latestValue} <span class="fs-6">${latestUnit}</span>
    </p><br>
    <span class="badge ${inRange ? 'bg-success' : borderline ? 'bg-warning' : 'bg-danger'}">
      ${inRange
        ? '<i class="bi bi-check-circle"></i> Within range'
        : borderline
          ? '<i class="bi bi-exclamation-circle"></i> Borderline high'
          : 'Out of Range ⚠️'}
    </span><br>
    <span class="badge bg-light text-dark mt-1"><strong>Timing:</strong> ${latestLabel}</span><br>
    <span class="text-info small mt-2 d-block">
      <i class="bi bi-info-circle"></i> ${advisoryMessage}
    </span>
  ` : `<p class="text-muted mb-1">No recent readings</p>`;
    </script>


    <script>
        // Apply dark mode on first visit if system prefers dark
        if (localStorage.getItem("darkMode") === null && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            localStorage.setItem("darkMode", "enabled");
            document.body.classList.add("dark-mode");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("darkModeToggle");
            const icon = document.getElementById("darkModeIcon");
            const body = document.body;

            // Apply mode based on saved preference
            function applyDarkMode(enabled) {
                body.classList.toggle("dark-mode", enabled);
                icon.className = enabled ? "bi bi-moon-stars-fill" : "bi bi-sun-fill";
            }

            const isDark = localStorage.getItem("darkMode") === "enabled";
            applyDarkMode(isDark);

            // Toggle mode and save preference
            toggleBtn?.addEventListener("click", () => {
                const nowDark = !body.classList.contains("dark-mode");
                localStorage.setItem("darkMode", nowDark ? "enabled" : "disabled");
                applyDarkMode(nowDark);
            });
        });
    </script>
    <script>
        const start = new Date("{{ $user->trial_start_date }}");
        const totalTrialDays = 7;
        const msPerDay = 1000 * 60 * 60 * 24;
        const elapsed = Math.floor((Date.now() - start.getTime()) / msPerDay);
        const daysLeft = Math.max(totalTrialDays - elapsed, 0);
    </script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", () => {
                navigator.serviceWorker.register("/sw.js")
                    .then(reg => console.log("SW registered:", reg.scope))
                    .catch(err => console.error("SW registration failed:", err));
            });
        }
    </script>
    <!-- ✅ Button & iOS Tip -->


    <!-- 🔔 Install Button for Desktop & Android -->
    <div id="installPrompt">📲 Add to Home Screen</div>

    <!-- iOS Tip -->
    <div id="iosInstallTip" style="display: none;">
        📱 To install, tap <strong>Share</strong> → <strong>Add to Home Screen</strong>
        <button class="dismiss-ios">×</button>
    </div>

    <!-- Android Tip -->
    <div id="androidInstallTip" style="display: none;">
        📲 You can install this app — look for "Install" in your browser menu!
        <button class="dismiss-android">×</button>
    </div>

    <!-- ✅ JS Logic -->
    <script>
        let deferredPrompt;
        const installBtn = document.getElementById("installPrompt");
        const iosTip = document.getElementById("iosInstallTip");
        const androidTip = document.getElementById("androidInstallTip");

        // 🔔 Desktop/Android: Handle beforeinstallprompt
        window.addEventListener("beforeinstallprompt", (e) => {
            e.preventDefault();
            deferredPrompt = e;

            installBtn.classList.add("fade-in");
            installBtn.style.display = "block";

            // Fade out after 10s
            setTimeout(() => {
                installBtn.classList.remove("fade-in");
                installBtn.classList.add("fade-out");
                setTimeout(() => installBtn.style.display = "none", 600);
            }, 10000);

            // Re-show after scroll + 30s
            let scrollTriggered = false;
            window.addEventListener("scroll", () => {
                if (!scrollTriggered && window.scrollY > 100) {
                    scrollTriggered = true;
                    setTimeout(() => {
                        if (deferredPrompt) {
                            installBtn.classList.remove("fade-out");
                            installBtn.classList.add("fade-in");
                            installBtn.style.display = "block";
                        }
                    }, 30000);
                }
            });
        });

        // 📲 Click handler for install
        installBtn.addEventListener("click", async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const result = await deferredPrompt.userChoice;
                if (result.outcome === "accepted") {
                    console.log("✅ User installed");
                } else {
                    console.log("❌ User dismissed");
                }
                deferredPrompt = null;
                installBtn.style.display = "none";
            }
        });

        // 🍎 iOS Safari Detection
        const isIOS = /iphone|ipad|ipod/.test(navigator.userAgent.toLowerCase());
        const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

        if (isIOS && isSafari && localStorage.getItem("iosTipDismissed") !== "true") {
            iosTip.classList.add("fade-in");
            iosTip.style.display = "block";

            setTimeout(() => {
                iosTip.classList.remove("fade-in");
                iosTip.classList.add("fade-out");
                setTimeout(() => iosTip.style.display = "none", 600);
            }, 10000);

            // Re-show after 30s only if not dismissed
            setTimeout(() => {
                if (localStorage.getItem("iosTipDismissed") !== "true") {
                    iosTip.classList.remove("fade-out");
                    iosTip.classList.add("fade-in");
                    iosTip.style.display = "block";
                }
            }, 30000);
        }

        // 🤖 Android Chrome Detection
        const isAndroid = /android/.test(navigator.userAgent.toLowerCase());
        const isChrome = /chrome/.test(navigator.userAgent.toLowerCase());

        if (isAndroid && isChrome && localStorage.getItem("androidTipDismissed") !== "true") {
            setTimeout(() => {
                androidTip.classList.add("fade-in");
                androidTip.style.display = "block";

                setTimeout(() => {
                    androidTip.classList.remove("fade-in");
                    androidTip.classList.add("fade-out");
                    setTimeout(() => androidTip.style.display = "none", 600);
                }, 10000);
            }, 45000);
        }

        // ❌ Close buttons
        document.querySelectorAll(".dismiss-ios").forEach(btn =>
            btn.addEventListener("click", () => {
                iosTip.style.display = "none";
                localStorage.setItem("iosTipDismissed", "true");
            })
        );

        document.querySelectorAll(".dismiss-android").forEach(btn =>
            btn.addEventListener("click", () => {
                androidTip.style.display = "none";
                localStorage.setItem("androidTipDismissed", "true");
            })
        );
    </script>

    <script>
        function fetchUnreadCount() {
            fetch("{{ route('notifications.unread.count') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector(".bell-active .badge");
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.classList.remove("d-none");
                    } else {
                        badge.classList.add("d-none");
                    }
                });
        }

        setInterval(fetchUnreadCount, 10000); // every 10 seconds
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseTarget = document.getElementById('symptomLogCollapse');
            const toggleBtn = document.querySelector('[data-bs-target="#symptomLogCollapse"]');
            const chevron = toggleBtn.querySelector('.chevron-icon');

            const savedState = localStorage.getItem('symptomCollapse');
            const shouldCollapse = savedState === 'collapsed';

            if (shouldCollapse) {
                const bsCollapse = new bootstrap.Collapse(collapseTarget, {
                    toggle: false
                });
                bsCollapse.hide();
                chevron.classList.remove('rotate');
            }

            toggleBtn.addEventListener('click', function() {
                const isCollapsed = collapseTarget.classList.contains('show');
                localStorage.setItem('symptomCollapse', isCollapsed ? 'collapsed' : 'expanded');
                chevron.classList.toggle('rotate', !isCollapsed);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseTarget = document.getElementById('mealHistoryCollapse');
            const toggleBtn = document.querySelector('[data-bs-target="#mealHistoryCollapse"]');
            const chevron = toggleBtn.querySelector('.chevron-icon');

            const savedState = localStorage.getItem('mealHistoryCollapse');
            const shouldCollapse = savedState === 'collapsed';

            if (shouldCollapse) {
                const bsCollapse = new bootstrap.Collapse(collapseTarget, {
                    toggle: false
                });
                bsCollapse.hide();
                chevron.classList.remove('rotate');
            }

            toggleBtn.addEventListener('click', function() {
                const isCollapsed = collapseTarget.classList.contains('show');
                localStorage.setItem('mealHistoryCollapse', isCollapsed ? 'collapsed' : 'expanded');
                chevron.classList.toggle('rotate', !isCollapsed);
            });
        });
    </script>


</body>

</html>
