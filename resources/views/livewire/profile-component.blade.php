<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif

  <div class="card mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="row">
            <div class="col-md-2">
              <img src="{{ env('ASSETS_URL') }}/img/user-profile.png" class="img-fluid rounded-circle" alt="Foto Profil">
            </div>
            <div class="col-md-10">
              <h5>{{ $loadUser->fullname }}</h5>
              <table>
                <tbody>
                  <tr>
                    <th>Username</th>
                    <td class="px-2">:</td>
                    <td>{{ $loadUser->username }}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td class="px-2">:</td>
                    <td>{{ $loadUser->email }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="row">
            <div class="col-md-12">
              <table>
                <tbody>
                  <tr>
                    <th>Role</th>
                    <td class="px-2">:</td>
                    <td>{{ $loadUser->master_role->name }}</td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td class="px-2">:</td>
                    <td>
                      @if ($loadUser->status == true)
                      <span class="badge text-bg-success">Active</span>
                      @else
                      <span class="badge text-bg-warning">In-Active</span>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="card p-3">
    <h5 class="card-title">Ganti Password</h5>
    <form wire:submit.prevent='confirmChangePass({{ $loadUser->id }})'>
      <div class="mb-2">
        <div>
          <label for="curr_password" class="form-label mb-0">Password Saat Ini</label>
          <input wire:model='curr_password' type="password" class="form-control" id="curr_password" placeholder="Masukkan password saat ini">
        </div>
        @error('curr_password')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="mb-2">
        <div>
          <label for="new_pass" class="form-label mb-0">Password Baru</label>
          <input wire:model='new_pass' type="password" class="form-control" id="new_pass" placeholder="Masukkan password baru">
        </div>
        @error('new_pass')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <div class="mb-3">
        <div>
          <label for="new_co_pass" class="form-label mb-0">Konfirmasi Password Baru</label>
          <input wire:model='new_co_pass' type="password" class="form-control" id="new_co_pass" placeholder="Konfirmasi password baru">
        </div>
        @error('new_co_pass')
        <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>
      <button type="submit" class="btn btn-primary">Ubah Password</button>
    </form>
  </div>

  <script>
    window.addEventListener('open-confirm', event => {
      const evtData = event.detail[0];
      Swal.fire({
        title: evtData.title,
        text: evtData.text,
        icon: evtData.icon,
        showCancelButton: evtData.showCancelButton,
        confirmButtonText: evtData.confirmButtonText,
        cancelButtonText: evtData.cancelButtonText,
        reverseButtons: evtData.reverseButtons
      }).then((result) => {
        if (result.isConfirmed) {
          Livewire.dispatch(evtData.triger_fn, { data_id: evtData.data_id });
        };
      });
    });
  </script>
</div>