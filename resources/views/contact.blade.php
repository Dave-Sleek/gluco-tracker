<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Gluco-Tracker</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{url('frontend/assets/css/style.css')}}">
</head>
<body>
<section class="py-5">
  <div class="container">
    <h2 class="mb-4 fw-bold text-center">Contact Us</h2>
    <p class="text-center mb-5 text-muted">Have a question or suggestion? Drop us a message and we’ll get back to you.</p>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('contact.submit') }}" class="mx-auto" style="max-width: 600px;">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
  </div>
</section>

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
 <!-- <script src="{{url('frontend/assets/js/auth.js')}}"></script> -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
