<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'App')</title>
    
    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Global Styles --}}
    <style>
        body {
            background: #f8f9fa;
        }
        .notification-card {
            border-left: 5px solid #0d6efd;
            transition: transform 0.2s;
        }
        .notification-card:hover {
            transform: scale(1.01);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .dismiss-btn, .mark-btn {
            border: none;
            background: transparent;
            color: #0d6efd;
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
  0% { transform: rotate(0); }
  25% { transform: rotate(15deg); }
  50% { transform: rotate(-10deg); }
  75% { transform: rotate(10deg); }
  100% { transform: rotate(0); }
}

</style>

    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body>

    <div class="container py-4">
        {{-- Content Section --}}
        @yield('content')
    </div>

    {{-- Bootstrap JS (Optional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>

<script>
  // Apply dark mode on first visit if system prefers dark
  if (localStorage.getItem("darkMode") === null && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    localStorage.setItem("darkMode", "enabled");
    document.body.classList.add("dark-mode");
  }

  document.addEventListener("DOMContentLoaded", function () {
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
