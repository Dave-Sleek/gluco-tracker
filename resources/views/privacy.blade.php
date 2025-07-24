<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - GlucoTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/assets/css/style.css')}}">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h1 class="card-title text-primary mb-4">Privacy Policy</h1>
                <p>At <strong>GlucoTracker</strong>, we value and protect your privacy. This Privacy Policy outlines how we collect, use, and safeguard your personal information.</p>
                <h4 class="mt-4">1. Information We Collect</h4>
                <ul>
                    <li><strong>Account Info:</strong> Name, email address, and password.</li>
                    <li><strong>Health Data:</strong> Blood sugar readings, time of readings, and related input.</li>
                    <li><strong>Device Info:</strong> Browser type, IP address, and device used (for analytics and security).</li>
                </ul>
                <h4 class="mt-4">2. How We Use Your Information</h4>
                <ul>
                    <li>To provide personalized blood sugar tracking and recommendations.</li>
                    <li>To send reminders and notifications (only if enabled by you).</li>
                    <li>To generate reports for your medical consultations.</li>
                    <li>To improve our service and maintain security.</li>
                </ul>
                <h4 class="mt-4">3. Data Security</h4>
                <p>
                    We use industry-standard encryption and security measures to protect your data. Access to your data is limited to authorized personnel only.
                </p>
                <h4 class="mt-4">4. Data Sharing</h4>
                <p>
                    We do not sell or share your personal data with third parties without your explicit consent. You may choose to share reports with your healthcare provider via secure links.
                </p>
                <h4 class="mt-4">5. Your Rights</h4>
                <ul>
                    <li>Access or download your data at any time.</li>
                    <li>Request deletion of your account and associated data.</li>
                    <li>Opt-out of notifications or data tracking.</li>
                </ul>
                <h4 class="mt-4">6. Changes to This Policy</h4>
                <p>
                    We may update this policy from time to time. Changes will be communicated through your dashboard or email notifications.
                </p>
                <h4 class="mt-4">7. Contact Us</h4>
                <p>
                    If you have questions about this policy, contact us at: <a href="mailto:support@bloodsugartracker.com">support@bloodsugartracker.com</a>
                </p>

                <div class="alert alert-info mt-4" role="alert">
                    <p>🛡️ Your health data is yours — we just help you make sense of it.</p>
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