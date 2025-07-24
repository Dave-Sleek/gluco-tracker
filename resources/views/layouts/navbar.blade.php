<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">GlucoTracker</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        @guest
          <li class="nav-item">
            <button class="btn btn-outline-primary ms-3" data-bs-toggle="modal" data-bs-target="#authModal">
              Login / Register
            </button>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('analytics') }}">Analytics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('doctor') }}">Dr. Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('advance_search') }}">Advance Search</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('Recommendation') }}">Smart Recommendations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('subscription') }}"><i class="fa fa-dollar"></i></a>
          </li>
          <li class="nav-item">
            <a class="position-relative me-3 text-decoration-none" href="{{ route('profile') }}">
              <i class="fa fa-gear"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="position-relative me-3 text-decoration-none" href="{{ route('help_support') }}">
              <i class="fa fa-question-circle"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-primary btn-sm" href="{{ route('logout') }}">
              <i class="fa fa-sign-out"></i> Logout
            </a>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
