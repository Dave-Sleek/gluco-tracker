<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About - Gluco-Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/assets/css/style.css')}}">
</head>
<body class="bg-light">
    <div class="container my-5">
    <div class="card shadow-lg rounded">
        <div class="card-body p-5">
            <h1 class="card-title text-primary mb-4">About GlucoTracker</h1>
            <p class="card-text">
                <strong>GlucoTracker</strong> is a smart, health-focused web application designed to help you monitor, understand, and manage your blood glucose levels with precision and ease. Whether you're navigating diabetes, fatigue, or simply optimizing your lifestyle, GlucoTracker offers intuitive tools to guide your daily choices.
            </p>
            
            <h4 class="mt-4">Key Features</h4>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item">📈 Log and track blood sugar readings with ease</li>
                <li class="list-group-item">📊 Visual analytics to track progress and spot trends over time</li>
                <li class="list-group-item">🧠 Smart meal recommendations based on glucose, fatigue, or your preferred nutrition style</li>
                <li class="list-group-item">🍽️ Choose from Balanced, Low Glycemic, or Energy Booster meals — or let the system decide intelligently</li>
                <li class="list-group-item">📅 Add meals to your personal plan and stay on track effortlessly</li>
                <li class="list-group-item">🔍 Use Advanced Search to explore meals, symptoms, or health logs with precision</li>
                <li class="list-group-item">📄 Download a personalized Doctor Report for clean, printable summaries of your health journey</li>
                <li class="list-group-item">🔁 Swap meals instantly and explore new suggestions on demand</li>
                <li class="list-group-item">⏰ Receive health alerts, gentle nudges, and push notifications</li>
                <li class="list-group-item">🔐 Your data is securely encrypted and always under your control</li>
            </ul>

            <h4>Your Privacy Matters</h4>
            <p class="card-text">
                Your data belongs to you. All health information is securely encrypted and stored privately. We never share it without your consent — your trust is our foundation.
            </p>

            <h4>Why Track Blood Sugar?</h4>
            <p class="card-text">
                Daily tracking helps uncover patterns, prevent complications, and make smarter lifestyle choices. With GlucoTracker, you'll understand how meals, energy, and habits affect your well-being — and you'll have tools to take action right away.
            </p>

            <div class="alert alert-success mt-4" role="alert">
                💙 Thank you for choosing GlucoTracker as your trusted companion on the journey to better health.
            </div>
        </div>
    </div>
</div>

     <!-- Footer -->
  <!-- Footer -->
<footer id="footer" class="bg-dark text-white pt-5 pb-3">
  <div class="container">
    <div class="row">
      <!-- Branding -->
      <div class="col-md-4 mb-4">
        <h5 class="text-uppercase fw-bold"><img src="{{asset('frontend/assets/img/logo-icon-GT.png')}}"></h5>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>