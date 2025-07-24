<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gluco-Tracker - How It Works</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/assets/css/style.css')}}">
</head>
<body>
<!-- How It Works Page -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-5 fw-bold text-dark">
      <span class="border-bottom border-3 border-success pb-2">How It Works</span>
    </h2>
    <div class="row g-4">
      <!-- Step 1 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 p-4">
          <img src="{{ asset('frontend/assets/img/enter-value.jpg') }}" class="img-fluid rounded mb-3" alt="Enter Value">
          <h5 class="fw-semibold text-primary">1. Enter Value</h5>
          <p class="text-muted small">Type in your blood sugar reading manually or import from a device.</p>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 p-4">
          <img src="{{ asset('frontend/assets/img/choose-unit.jpg') }}" class="img-fluid rounded mb-3" alt="Choose Unit">
          <h5 class="fw-semibold text-success">2. Choose Unit</h5>
          <p class="text-muted small">Select mg/dL or mmol/L for automatic conversion and clarity.</p>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0 p-4">
          <img src="{{ asset('frontend/assets/img/save-export.jpg') }}" class="img-fluid rounded mb-3" alt="Save & Export">
          <h5 class="fw-semibold text-danger">3. Save & Export</h5>
          <p class="text-muted small">Track your progress and download your history in CSV format.</p>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <a href="{{ url('/convert') }}" class="btn btn-primary btn-lg">Try the Converter</a>
    </div>
  </div>
</section>
<!-- Footer -->
<footer id="footer" class="bg-dark text-white pt-5 pb-3">
  <div class="container">
    <div class="row">
      <!-- Branding -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase fw-bold">GlucoTracker</h5>
        <p class="text-light">Empowering you to monitor and manage your blood sugar levels with ease and accuracy.</p>
      </div>

      <!-- Links -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
          <li><a href="{{ url('/about') }}" class="text-white text-decoration-none">About</a></li>
          <li><a href="{{ url('/contact') }}" class="text-white text-decoration-none">Contact</a></li>
          <li><a href="{{ url('/terms') }}" class="text-white text-decoration-none">Terms of Service</a></li>
          <li><a href="{{ url('/privacy') }}" class="text-white text-decoration-none">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Social & Contact -->
      <div class="col-md-4 mb-4">
        <h6 class="text-uppercase">Connect</h6>
        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
        <a href="#" class="text-white me-3"><i class="bi bi-twitter fs-5"></i></a>
        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
        <a href="#" class="text-white"><i class="bi bi-envelope fs-5"></i></a>
        <p class="small mt-3">Email: support@glucotracker.com</p>
      </div>
    </div>

    <hr class="border-secondary" />

    <div class="text-center">
      <p class="mb-0 small">&copy; {{ now()->year }} GlucoTracker. All rights reserved.</p>
    </div>
  </div>
</footer>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("darkModeToggle");
  const icon = document.getElementById("darkModeIcon");
  const body = document.body;

  function applyDarkMode(enabled) {
    if (enabled) {
      body.classList.add("dark-mode");
      icon.classList.replace("bi-sun-fill", "bi-moon-stars-fill");
    } else {
      body.classList.remove("dark-mode");
      icon.classList.replace("bi-moon-stars-fill", "bi-sun-fill");
    }
  }

  const isDark = localStorage.getItem("darkMode") === "enabled";
  applyDarkMode(isDark);

  toggleBtn.addEventListener("click", () => {
    const currentlyDark = body.classList.contains("dark-mode");
    localStorage.setItem("darkMode", currentlyDark ? "disabled" : "enabled");
    applyDarkMode(!currentlyDark);
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
