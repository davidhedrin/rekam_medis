<div>
  @if (Session::has('msgAlert'))
    <div class="toast-container">
      <div class="toast fade show align-items-center text-white bg-{{ Session::get('msgAlert')['status'] }} border-0 p-2" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex justify-content-between">
          <div class="d-flex">
            <div>
              @if (Session::get('msgAlert')['status'] == 'success')
              <i class='bx bx-check-circle bx-tada fs-4'></i>
              @elseif (Session::get('msgAlert')['status'] == 'warning')
              <i class='bx bx-message-square-error bx-tada fs-4'></i>
              @elseif (Session::get('msgAlert')['status'] == 'danger')
              <i class='bx bx-shield-x bx-tada fs-4'></i>
              @elseif (Session::get('msgAlert')['status'] == 'info')
              <i class='bx bx-info-circle bx-tada fs-4'></i>
              @endif
            </div>
            <div class="ms-1">
              <strong class="d-block">{{ Session::get('msgAlert')['title'] }}</strong>
            </div>
          </div>

          <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div>
          {{ Session::get('msgAlert')['message'] }}
        </div>
      </div>
    </div>
  @endif

  <style>
    .toast-container {
      position: fixed;
      top: 1rem;
      right: 1rem;
      z-index: 1050;
    }
  </style>
</div>