<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Health Tracker') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Optional Stack Styles -->
    @stack('styles')
</head>

<body class="bg-light text-dark">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                @php
                    $route = request()->route()?->getName();
                @endphp

                @switch($route)
                    @case('symptoms')
                        🩺 Symptom Tracker
                    @break

                    @case('meal-log')
                        🍽️ Meal Log
                    @break

                    @case('meal-suggestions')
                        🧠 Meal Planner
                    @break

                    @default
                        {{ config('app.name', 'Health Tracker') }}
                @endswitch
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer (optional) -->
    {{-- <footer class="text-center mt-4 text-muted small">
        &copy; {{ date('Y') }} Built with ❤️
    </footer> --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Optional Scripts -->
    @stack('scripts')
    @yield('scripts')
</body>

</html>
