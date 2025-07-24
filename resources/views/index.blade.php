<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json">
    <title>Gluco-Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('frontend/assets/css/style.css') }}">

    <style>
        .feature-card .card-title {
            font-size: 1.6rem;
            /* or 1.2rem */
        }
    </style>
</head>

<body>
    <!-- Bootstrap Header -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><img
                    src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}"></a>
            <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip"
                title="Toggle Dark Mode">
                <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
            </button>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#how-it-works">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item">
                        <button class="btn btn-outline-primary ms-3" data-bs-toggle="modal"
                            data-bs-target="#authModal">Login / Register</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="text-center py-5"
        style="
    background-image: url('{{ asset('frontend/assets/img/gbg.jpg') }}');
    background-size: cover;
    background-position: center 20%;
    background-repeat: no-repeat;
    min-height: 400px;
    position: relative;
    color: black;
  ">
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start fade-in-overlay"
                    style="
       background-color: rgba(0, 0, 0, 0.7);
       padding: 30px;
       border-radius: 12px;
       box-shadow: 0 0 20px rgba(0,0,0,0.3);
       color: white;
     ">
                    <h1 class="display-4 fw-bold text-light">Track Your Blood Sugar Smarter</h1>
                    <p class="lead text-light">Convert readings, monitor trends, and take control of your health.</p>
                    <a href="#converter" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                        data-bs-target="#authModal">Get Started</a>
                    <a href="#features" class="btn btn-success btn-lg ms-2">Learn More</a>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="py-5 bg-white text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold text-dark">
                <span class="border-bottom border-3 border-primary pb-2">Features</span>
            </h2>
            <div class="row g-4">
                <!-- Feature Card 1 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 feature-card">
                        <i class="bi bi-arrow-left-right text-primary fs-1 mb-3"></i>
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-semibold">Instant Conversion</h5>
                            <p class="card-text text-muted small">
                                Seamlessly toggle between mg/dL and mmol/L no calculator required. Whether you're
                                managing diabetes from the US, UK, or beyond, the app adapts to your preferred unit
                                instantly using clinically validated formulas. The conversion is precise, fast, and
                                visible across all your readings and reports.
                                <br><br>
                                Ideal for international users, caregivers, or healthcare professionals needing
                                cross-unit clarity.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 feature-card">
                        <i class="bi bi-graph-up text-success fs-1 mb-3"></i>
                        <div class="card-body">
                            <h5 class="card-title text-success fw-semibold">Track Progress</h5>
                            <p class="card-text text-muted small">
                                Visualize your blood sugar journey with interactive charts and historical insights.
                                Easily monitor trends over time to spot improvements, setbacks, and potential risk
                                zones. The timeline view helps you stay accountable and share progress with doctors or
                                loved ones when needed.
                                <br><br>
                                A powerful way to turn data into meaningful health decisions.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 feature-card">
                        <i class="bi bi-heart-pulse text-danger fs-1 mb-3"></i>
                        <div class="card-body">
                            <h5 class="card-title text-danger fw-semibold">Health Tips</h5>
                            <p class="card-text text-muted small">
                                Receive personalized wellness advice based on your latest readings, habits, and goals.
                                From nutrition and exercise to sleep and hydration, our intelligent tips help guide you
                                toward better choices without overwhelming you with jargon.
                                <br><br>
                                Designed to inform, not lecture so your care plan feels like a collaboration.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 4 -->
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm border-0 feature-card">
                        <i class="bi bi-file-earmark-arrow-down text-warning fs-1 mb-3"></i>
                        <div class="card-body">
                            <h5 class="card-title text-warning fw-semibold">Export to CSV</h5>
                            <p class="card-text text-muted small">
                                Download your complete data set in one click for offline access, medical reviews, or
                                spreadsheet analysis. The CSV format makes it easy to share with healthcare providers or
                                import into your favorite tracking tools.
                                <br><br>
                                Perfect for keeping your records tidy, portable, and actionable.
                            </p>
                        </div>
                    </div>
                </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="mb-5 fw-bold text-dark">
                <span class="border-bottom border-3 border-success pb-2">How It Works</span>
            </h2>
            <div class="row g-4">
                <!-- Step 1 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 step-card py-4 fade-in-step">
                        <i class="bi bi-pencil-square text-primary fs-1 mb-3"></i>
                        <h5 class="fw-semibold">1. Enter Value</h5>
                        <p class="text-muted small">Type in your blood sugar reading.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 step-card py-4 fade-in-step">
                        <i class="bi bi-sliders text-success fs-1 mb-3"></i>
                        <h5 class="fw-semibold">2. Choose Unit</h5>
                        <p class="text-muted small">Select mg/dL or mmol/L for automatic conversion.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 step-card py-4 fade-in-step">
                        <i class="bi bi-cloud-arrow-down text-danger fs-1 mb-3"></i>
                        <h5 class="fw-semibold">3. Save & Export</h5>
                        <p class="text-muted small">Track your data and download your history.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="benefits-summary" class="bg-primary text-white text-center py-5">
        <div class="container">
            <h2 class="mb-4 fw-bold">Why Choose GlucoTracker?</h2>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <p><i class="bi bi-check-circle-fill fs-3 text-light"></i><br> Fast & Secure Conversion</p>
                </div>
                <div class="col-md-3">
                    <p><i class="bi bi-check-circle-fill fs-3 text-light"></i><br> Personalized Tracking</p>
                </div>
                <div class="col-md-3">
                    <p><i class="bi bi-check-circle-fill fs-3 text-light"></i><br> Easy Data Export</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <!-- <section id="testimonials" class="bg-primary text-white text-center py-5">
  <div class="container">
    <h2 class="mb-4 fw-bold">What Users Say</h2>
    <p class="fst-italic">“I track my sugar effortlessly now — the converter is brilliant!”</p>
    <p class="fst-italic">“Exporting my log for my doctor is so easy.”</p>
    <a href="about.php" class="btn btn-light btn-lg mt-3">Read More Reviews</a>
  </div>
</section> -->

    <!-- Login/Register Modal -->
    <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authModalLabel">Login / Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="authForm" data-login="{{ route('login') }}" data-register="{{ route('register') }}">
                        @csrf
                        <input type="hidden" id="authType" value="login" />
                        <div class="mb-3 d-none" id="nameField">
                            <label>Name</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" id="email" name="email" class="form-control" required />
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>
                        <div class="d-grid">
                            <a href="{{ route('forgot-password.request') }}">Forgot Password?</a>
                            <div class="text-center my-3"><span> </span></div>
                            <button type="submit" class="btn btn-primary" id="authBtn">Login</button>
                            <div class="text-center my-3">
                                <a href="{{ route('google.login') }}" class="btn btn-outline-primary">
                                    <img src="/icons/google-icon.svg" alt="Google"
                                        style="height: 20px; margin-right: 8px;">
                                    Login with Google
                                </a>

                            </div>
                        </div>
                        <p class="mt-3 text-center">
                            <a href="#" id="toggleAuth">Don't have an account? Register</a>
                        </p>
                    </form>
                    <div id="authMessage" class="mt-3 text-center text-success"></div>
                    <div id="authErrors" class="mt-3 text-center text-danger"></div>


                </div>
            </div>
        </div>
    </div>

    <script>
        console.log("Login URL:", "{{ route('login') }}");
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const authForm = document.getElementById("authForm");
            const authType = document.getElementById("authType");
            const toggleLink = document.getElementById("toggleAuth");
            const authBtn = document.getElementById("authBtn");
            const nameField = document.getElementById("nameField");
            const authMessage = document.getElementById("authMessage");
            const authErrors = document.getElementById("authErrors");

            const loginUrl = authForm.dataset.login;
            const registerUrl = authForm.dataset.register;

            toggleLink.addEventListener("click", function(e) {
                e.preventDefault();
                const isLogin = authType.value === "login";

                authType.value = isLogin ? "register" : "login";
                authBtn.textContent = isLogin ? "Register" : "Login";
                toggleLink.textContent = isLogin ? "Already have an account? Login" :
                    "Don't have an account? Register";
                nameField.classList.toggle("d-none");
            });

            authForm.addEventListener("submit", function(e) {
                e.preventDefault();

                authBtn.disabled = true;
                authBtn.textContent = authType.value === "login" ? "Logging in..." : "Registering...";
                authErrors.innerHTML = "";
                authMessage.innerHTML = "";

                const formData = {
                    _token: document.querySelector('input[name="_token"]').value,
                    email: document.getElementById("email").value,
                    password: document.getElementById("password").value,
                };

                if (authType.value === "register") {
                    formData.full_name = document.getElementById("full_name").value;
                }

                const url = authType.value === "login" ? loginUrl : registerUrl;

                fetch(url, {
                        method: "POST",
                        headers: {
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": formData._token
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(async response => {
                        const data = await response.json();
                        authBtn.disabled = false;
                        authBtn.textContent = authType.value === "login" ? "Login" : "Register";

                        if (response.ok) {
                            authMessage.innerHTML =
                                `<div class="alert alert-success">${data.message || 'Success! Redirecting...'}</div>`;
                            // setTimeout(() => {
                            //   window.location.href = data.redirect || "/dashboard";
                            // }, 1500);
                            setTimeout(() => {
                                if (data.is_admin) {
                                    window.location.href = "/admin/dashboard";
                                } else {
                                    window.location.href = data.redirect || "/dashboard";
                                }
                            }, 1500);
                        } else {
                            // Handle validation errors
                            if (data.errors) {
                                const errorMessages = Object.values(data.errors).flat().join(
                                    "<br>");
                                authErrors.innerHTML =
                                    `<div class="alert alert-danger">${errorMessages}</div>`;
                            } else if (data.message) {
                                authErrors.innerHTML =
                                    `<div class="alert alert-danger">${data.message}</div>`;
                            } else {
                                authErrors.innerHTML =
                                    `<div class="alert alert-danger">Something went wrong. Try again.</div>`;
                            }
                        }
                    })
                    .catch(error => {
                        authBtn.disabled = false;
                        authBtn.textContent = authType.value === "login" ? "Login" : "Register";
                        authErrors.innerHTML =
                            `<div class="alert alert-danger">Request failed. Check your internet connection.</div>`;
                        console.error("Error:", error);
                    });
            });
        });
    </script>

    <div id="cookieBanner" style="display: none;">
        <div
            style="
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #333;
    color: #fff;
    padding: 16px;
    text-align: center;
    z-index: 9999;
    font-size: 14px;
  ">
            🍪 We use cookies to improve your experience. By using our site, you accept cookies.
            <button id="acceptCookies"
                style="
      margin-left: 10px;
      background: #0d6efd;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
    ">Accept</button>
        </div>
    </div>

    <!-- Footer -->
    <footer id="footer" class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row">
                <!-- Branding -->
                <div class="col-md-4 mb-4">
                    <h5 class="text-uppercase fw-bold"><img
                            src="{{ asset('frontend/assets/img/logo-icon-GT.png') }}"></h5>
                    <p class="text-light">Empowering you to monitor and manage your blood sugar levels with ease and
                        accuracy.</p>
                </div>

                <!-- Links -->
                <div class="col-md-4 mb-4">
                    <h6 class="text-uppercase">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="{{ url('/about') }}" class="text-white text-decoration-none">About</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-white text-decoration-none">Contact</a></li>
                        <li><a href="{{ url('/terms') }}" class="text-white text-decoration-none">Terms of
                                Service</a></li>
                        <li><a href="{{ url('/privacy') }}" class="text-white text-decoration-none">Privacy
                                Policy</a></li>
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
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const banner = document.getElementById("cookieBanner");
            const acceptBtn = document.getElementById("acceptCookies");

            if (!localStorage.getItem("cookiesAccepted")) {
                banner.style.display = "block";
            }

            acceptBtn.addEventListener("click", () => {
                localStorage.setItem("cookiesAccepted", "true");
                banner.style.display = "none";
            });
        });
    </script>

    <!-- <script src="{{ url('frontend/assets/js/auth.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('frontend/assets/js/script.js') }}"></script>
</body>

</html>
