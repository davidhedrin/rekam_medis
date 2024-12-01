<aside id="sidebar" class="expand">
  <div class="d-flex">
    <button class="toggle-btn" type="button">
      <i class='bx bx-customize'></i>
    </button>
    <div class="sidebar-logo">
      <a href="#">Rekam Medis</a>
    </div>
  </div>
  <hr class="text-light">
  <ul class="sidebar-nav">
    <li class="sidebar-item">
      <a href="{{ route('home') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-tachometer fs-5'></i>
        </div>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{ route('rekam-medis') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-book-bookmark fs-5'></i>
        </div>
        <span>Rekam Medis</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{ route('report-medis') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-receipt fs-5'></i>
        </div>
        <span>Report Medis</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{ route('patient') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-user-pin fs-5'></i>
        </div>
        <span>Pasien</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{ route('staff') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-group fs-5'></i>
        </div>
        <span>Staff</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a href="{{ route('profile') }}" class="d-flex align-items-center items-center sidebar-link">
        <div>
          <i class='bx bx-user-circle fs-5'></i>
        </div>
        <span>Profile</span>
      </a>
    </li>
    {{-- <li class="sidebar-item">
      <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth"
        aria-expanded="false" aria-controls="auth">
        <i class='bx bx-user-circle'></i>
        <span>Multi</span>
      </a>
      <ul id="auth" class="sidebar-dropdown list-unstyled collapse ps-4" data-bs-parent="#sidebar">
        <li class="sidebar-item ms-2">
          <a href="#" class="sidebar-link">Login</a>
        </li>
        <li class="sidebar-item ms-2">
          <a href="#" class="sidebar-link">Register</a>
        </li>
      </ul>
    </li> --}}

    {{-- <li class="sidebar-item">
      <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#multi"
        aria-expanded="false" aria-controls="multi">
        <i class='bx bx-user-circle'></i>
        <span>Multi Level</span>
      </a>
      <ul id="multi" class="sidebar-dropdown list-unstyled collapse ps-4" data-bs-parent="#sidebar">
        <li class="sidebar-item">
          <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two"
            aria-expanded="false" aria-controls="multi-two">
            Two Links
          </a>
          <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse ps-3">
            <li class="sidebar-item">
              <a href="#" class="sidebar-link">Link 1</a>
            </li>
            <li class="sidebar-item">
              <a href="#" class="sidebar-link">Link 2</a>
            </li>
          </ul>
        </li>
      </ul>
    </li> --}}
  </ul>
  <div class="sidebar-footer">
    <a href="{{ route('logout') }}" class="d-flex align-items-center items-center sidebar-link">
      <div>
        <i class='bx bx-log-out fs-5'></i>
      </div>
      <span>Logout</span>
    </a>
  </div>
</aside>