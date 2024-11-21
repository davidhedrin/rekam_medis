<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif
  
  <div class="mb-2 text-end">
    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdd">
      Tambah
      <i class='bx bx-user-plus fs-5 ms-1'></i>
    </button>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Posisi</th>
          <th>Dibuat oleh</th>
          <th>Waktu dibuat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($loadDataUser as $data)
        <tr>
          <th>1</th>
          <td>{{ $data->fullname }}</td>
          <td>{{ $data->username }}</td>
          <td>{{ $data->master_role ? $data->master_role->name : '-' }}</td>
          <td>{{ $data->created_by }}</td>
          <td>{{ $data->created_at }}</td>
          <td>
            <a href="#">
              Detail <i class='bx bx-edit-alt'></i>
            </a>
          </td>
        </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center italic">Tidak ada data ditemukan!</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-2">
    {{ $loadDataUser->links() }}
  </div>

  <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAddLabel">Tambah Staff</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="storeNewStaff()">
          <div class="modal-body">
            <div class="mb-2">
              <div>
                <label for="fullname" class="form-label m-0">Nama Lengkap:</label>
                <input wire:model='fullname' type="text" class="form-control" id="fullname" placeholder="Masukkan nama lengkap">
              </div>
              @error('fullname')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-2">
              <div>
                <label for="username" class="form-label m-0">Username:</label>
                <input wire:model='username' type="text" class="form-control" id="username" placeholder="Masukkan username">
              </div>
              @error('username')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-2">
              <div>
                <label for="password" class="form-label m-0">Password:</label>
                <input wire:model='password' type="password" class="form-control" id="password" placeholder="**********">
              </div>
              @error('password')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-2">
              <div>
                <label for="co_password" class="form-label m-0">Konfirmasi Password:</label>
                <input wire:model='co_password' type="password" class="form-control" id="co_password" placeholder="**********">
              </div>
              @error('co_password')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-2">
              <div>
                <label for="email" class="form-label m-0">Email:</label>
                <input wire:model='email' type="email" class="form-control" id="email" placeholder="masukkan@alamat.email">
              </div>
              @error('email')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="mb-2">
              <div>
                <label for="role_id" class="form-label m-0">Role:</label>
                <select wire:model='role_id' id="role_id" class="form-select" aria-label="Default select example">
                  <option selected>Pilih role staff</option>
                  @foreach ($dataMasterRole as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                  @endforeach
                </select>
              </div>
              @error('role_id')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- <script>
  window.addEventListener('close-form-modal', event => {
    $('#modalAdd').modal('hide');
    $('#modalEdit').modal('hide');
    $('#modalDelete').modal('hide');
  });
  window.addEventListener('open-edit-modal', event => {
    $('#modalEdit').modal('show');
  });
</script> --}}