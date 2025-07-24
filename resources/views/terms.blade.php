<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - GlucoTracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- In header.php -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/assets/css/style.css')}}">

</head>
<body class="bg-light">
        <div class="card shadow-lg">
            <div class="card-body p-5">
    <div class="container mt-5">
    <h2 class="mb-4">Terms of Service</h2>
    <p class="text-muted">Last updated: May 28, 2025</p>
    <p>Welcome to our GlucoTracker application. By using our service, you agree to the following terms and conditions:</p>
    <ul>
        <li>✅ You must be at least 13 years old to use this app.</li>
        <li>✅ You are responsible for maintaining the security of your account credentials.</li>
        <li>✅ We reserve the right to suspend or terminate your account for violating these terms.</li>
        <li>✅ Data is stored securely, but we are not liable for unauthorized access due to your negligence.</li>
        <li>✅ You can export or delete your data at any time.</li>
    </ul>
    <h4 class="mt-5">Frequently Asked Questions</h4>
    <div class="accordion mt-3" id="faqAccordion">

        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1-heading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    📌 Is my health data private?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Yes. We use encryption and secure database practices. Your data is only accessible by you unless you explicitly share it.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                    📌 Can I delete my account and data?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Absolutely. You can request account deletion from your profile page. All data will be permanently removed.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq3-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                    📌 Do you sell my data to third parties?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    No. We do not sell, rent, or trade your data to third parties. Our platform is user-focused and privacy-respecting.
                </div>
            </div>
        </div>

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