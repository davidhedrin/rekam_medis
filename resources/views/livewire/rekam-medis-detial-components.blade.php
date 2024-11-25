<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif

  <a href="{{ route('rekam-medis') }}" class="d-inline-flex align-items-center items-center">
    <div class="me-1">
      <i class='bx bx-arrow-back fs-5'></i>
    </div>
    <div>
      Kembali
    </div>
  </a>
</div>
