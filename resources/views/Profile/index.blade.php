<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-header {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            padding: 3rem;
            border-radius: 1rem;
            color: white;
            margin-bottom: 2rem;
        }

        .profile-img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .profile-card {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .action-buttons a {
            margin-bottom: 10px;
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
        .dark-mode .profile-card,
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
</head>

<body>

    <div class="container">
        <div class="profile-header text-center">
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile" class="profile-img mb-3"
                id="preview" style="max-width: 150px;">
            <h2 class="mb-0">{{ $user->full_name }}</h2>
            <p class="mb-0">{{ $user->email }}</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div class="profile-card mx-auto mt-4" style="max-width: 600px;">
            <div class="mb-3">
                <form method="POST" action="{{ route('user.notifications.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="notifications_enabled" value="1"
                            {{ Auth::user()->notifications_enabled ? 'checked' : '' }}>
                        Enable Push Notifications
                    </label>

                    <button type="submit" class="btn btn-sm btn-primary ms-2">Save</button>
                </form>
            </div>
            <form method="POST" action="{{ route('Profile') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $user->full_name) }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $user->email) }}">
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control"
                        value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Mobile Number</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input class="form-control" type="file" id="profile_image" name="profile_image" accept="image/*"
                        onchange="previewImage(event)">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('ChangePassword') }}" class="btn btn-warning">Change Password</a>
                    <a href="{{ route('export_pdf') }}" class="btn btn-light">Download as PDF</a>
                    <a href="{{ route('account_delete') }}" class="btn btn-danger">Delete Account</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    document.getElementById('preview').src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
    @endsection
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
