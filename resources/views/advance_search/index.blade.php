<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Advanced Search</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
</head>
<body class="p-4">
  <!-- <button id="darkModeToggle" class="btn btn-sm bg-transparent" data-bs-toggle="tooltip" title="Toggle Dark Mode">
    <i id="darkModeIcon" class="bi bi-moon-stars-fill fs-5"></i>
  </button> -->

  <h2><i class="fa fa-search"></i> Advanced Search & Filter</h2>

  <form method="GET" class="row g-3 mb-4">
    <div class="col-md-3">
      <label class="form-label">Start Date</label>
      <input type="date" name="start_date" value="{{ old('start_date', $start_date) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">End Date</label>
      <input type="date" name="end_date" value="{{ old('end_date', $end_date) }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">Reading Type</label>
      <select name="type" class="form-select">
        <option value="">-- All Types --</option>
        <option value="fasting" {{ $type == 'fasting' ? 'selected' : '' }}>Fasting</option>
        <option value="after_meal" {{ $type == 'after_meal' ? 'selected' : '' }}>After Meal</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Label</label>
      <input type="text" name="label" value="{{ old('label', $label) }}" class="form-control" placeholder="e.g., Post breakfast">
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Apply Filters</button>
    </div>
  </form>

  <form method="GET" action="{{ route('export.csv') }}" class="mb-3">
    <input type="hidden" name="start_date" value="{{ $start_date }}">
    <input type="hidden" name="end_date" value="{{ $end_date }}">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="label" value="{{ $label }}">
    <button type="submit" class="btn btn-success">
      <i class="fa fa-download"></i> Export CSV
    </button>
  </form>

  <table class="table table-bordered table-hover">
    <thead class="table-light">
      <tr>
        <th>Date</th>
        <th>Reading</th>
        <th>Type</th>
        <th>Label</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $row)
        <tr>
          <td>{{ \Carbon\Carbon::parse($row->converted_at)->format('Y-m-d H:i') }}</td>
          <td>{{ $row->original_value }} {{ $row->original_unit }}</td>
          <td>{{ ucfirst($row->type) }}</td>
          <td>{{ $row->label }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @if ($totalPages > 1)
    <nav>
      <ul class="pagination">
        @for ($i = 1; $i <= $totalPages; $i++)
          <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
          </li>
        @endfor
      </ul>
    </nav>
  @endif
</body>

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
