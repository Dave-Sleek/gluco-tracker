@extends('layouts.doc')

@section('title', 'Doctor Reports')

<div class="container py-5">
  <!-- <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip" title="Toggle Dark Mode">
    <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
  </button> -->

  <h1 class="mb-4">Doctor Reports</h1>

  <!-- PDF Report Download -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Download PDF Report</h5>
      <p class="card-text">Download your latest blood sugar readings in a printable PDF format for your doctor.</p>
      <a href="{{ route('reports') }}" class="btn btn-primary">📄 Download PDF Report</a>
    </div>
  </div>

  <!-- Share Report with Doctor -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Share Report with Doctor</h5>
      <form id="shareReportForm" method="POST" action="{{ route('reports.share') }}">
        @csrf
        <div class="mb-3">
          <label for="password" class="form-label">Set a Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">🔗 Generate Shareable Link</button>
      </form>
      <div id="linkResult" class="mt-3"></div>
    </div>
  </div>
</div>


@push('styles')
<!-- External Styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Dark Mode Styling -->
<style>
/* Same CSS rules you provided... */
body.dark-mode { background-color: #121212 !important; color: #e0e0e0; }
/* ... other dark mode rules omitted for brevity */
</style>
@endpush

<script>
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("shareReportForm");
  const resultBox = document.getElementById("linkResult");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();
    
    const formData = new FormData(this);

    try {
      const response = await fetch("{{ route('reports') }}", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
      });

      const data = await response.json();

      if (data.link) {
        resultBox.innerHTML = `
          <div class="alert alert-info">
            🔗 Share this link with your doctor: <a href="${data.link}" target="_blank">${data.link}</a>
          </div>`;
      } else {
        resultBox.innerHTML = `<div class="alert alert-warning">⚠️ Something went wrong.</div>`;
      }

    } catch (err) {
      console.error(err);
      resultBox.innerHTML = `<div class="alert alert-danger">❌ Failed to generate link.</div>`;
    }
  });
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

</body>
</html>