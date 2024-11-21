<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif
  
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-4 p-3 bg-white shadow" style="max-width: 850px;">
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
        style="background: #103cbe;">
        <div class="featured-image mb-3">
          <img src="{{ asset('assets/img/1.png') }}" class="img-fluid" style="width: 250px;">
        </div>
        <div class="text-white fs-2">Be Verified</div>
        <small class="text-white text-wrap text-center">Join experienced Designers on this platform.</small>
      </div>

      <div class="col-md-6">
        <form wire:submit.prevent='loginUser()' class="row align-items-center py-3">
          <div class="header-text mb-4">
            <h3 class="m-0">Rekam Medis</h3>
            <small>We are happy to have you back.</small>
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input wire:model='username' id="username_login" type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Username">
            </div>
            @error('username')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <div class="input-group">
              <input wire:model='password' id="password_login" type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
            </div>
            @error('password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="input-group mb-3 d-flex justify-content-between">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="formCheck">
              <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
            </div>
            <div class="forgot">
              <small><a href="#">Forgot Password?</a></small>
            </div>
          </div>
          <div class="input-group">
            <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
          </div>
          {{-- <div class="row">
            <small>Don't have account? <a href="#">Sign Up</a></small>
          </div> --}}
        </form>
      </div>
    </div>
  </div>
</div>