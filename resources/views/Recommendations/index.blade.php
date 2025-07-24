<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Smart Recommendations</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body.dark-mode { background-color: #121212; color: white; }
    .recommendation-card {
      border-left: 5px solid #0d6efd;
      padding: 1rem;
      margin-bottom: 1rem;
      background: #f8f9fa;
    }
    .dark-mode .recommendation-card {
      background: #1f1f1f;
      border-left-color: #ffc107;
    }
  </style>
</head>
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
.dark-mode small,
.dark-mode label {
  color: #e0e0e0 !important;
}

/* Forms */
.dark-mode .form-control,
.dark-mode .form-select,
.dark-mode input,
.dark-mode select,
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
</style>
<body>
<div class="container py-5">
  <!-- <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip" title="Toggle Dark Mode">
    <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
  </button> -->

  <h2 class="mb-3">📊 Smart Health Recommendations</h2>
  <p class="text-muted">Based on your recent blood sugar readings:</p>

  @if (count($flags))
    <h5>🚩 Flagged Readings</h5>
    @foreach ($flags as $flag)
      <div class="recommendation-card text-dark bg-warning-subtle p-2 rounded mb-2">{{ $flag }}</div>
    @endforeach
  @endif

  <h5 class="mt-4">🧠 Smart Advice</h5>
  @foreach ($advice as $tip)
    <div class="recommendation-card text-dark bg-light p-2 rounded mb-2">{!! $tip !!}</div>
  @endforeach
  

  <h4 class="mt-5">📈 Recent Readings</h4>
  <canvas id="readingChart" height="100"></canvas>
</div>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('readingChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: {!! json_encode(collect($chartData)->pluck('converted_at')->reverse()->values()) !!},
      datasets: [{
        label: 'Blood Sugar (mg/dL)',
        data: {!! json_encode(collect($chartData)->pluck('original_value')->reverse()->values()) !!},
        borderColor: 'rgba(75, 192, 192, 1)',
        fill: false,
        tension: 0.2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Blood Sugar Trend'
        }
      }
    }
  });
</script>
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