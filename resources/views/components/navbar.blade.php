<div>
  <nav class="navbar navbar-expand px-4 py-3">
    <div class="d-none d-sm-inline-block fw-semibold fs-5">
      <div class="d-flex align-items-center items-center">
        @if (Session::has('activePage'))
        <div style="line-height: 0">
          <i class='{{ Session::get('activePage')['icon'] }} fs-4'></i>
        </div>
        <div class="ms-1">
          {{ Session::get('activePage')['name'] }}
        </div>
        @else
        Rekam Medis
        @endif
      </div>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <div data-bs-toggle="dropdown" class="d-flex align-items-center nav-icon pe-md-0" style="cursor: pointer">
            <div class="me-1">
              <small>Hi, {{ Auth::user()->fullname }}</small>
            </div>
            <i class='bx bx-user-circle fs-4'></i>
          </div>
          <div class="dropdown-menu dropdown-menu-end rounded px-3">
            <div class="text-dark">
              <a href=""><i class='bx bx-user-circle fs-6'></i> <small>Profil</small></a>
            </div>
            <div class="text-dark">
              <a href="{{ route('logout') }}"><i class='bx bx-log-out fs-6'></i> <small>Logout</small></a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</div>