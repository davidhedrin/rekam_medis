<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif
  
  <div class="mb-2 text-end">
    <button wire:click='ClearData()' type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalAdd">
      Tambah
      <i class='bx bx-plus-circle fs-5 ms-1'></i>
    </button>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nomor Rekam</th>
          <th>Staff</th>
          <th>Pasien</th>
          <th>Total Rekam</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($loadData as $index => $data)
        <tr>
          <th>{{ $loadData->firstItem() + $index }}</th>
          <td>{{ $data->record_num }}</td>
          <td>{{ $data->user_name }}</td>
          <td>{{ $data->patient_name }}</td>
          <td>0</td>
          <td>
            <a wire:click='openDetailData({{ $data->id }})' href="javascript:void(0)">
              Detail <i class='bx bx-edit-alt'></i>
            </a>
          </td>
        </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center italic">Tidak ada data ditemukan!</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-2">
    {{ $loadData->links() }}
  </div>
  <livewire:components.select-with-search />
  
  <div wire:ignore.self class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAddLabel">Tambah Rekam Medis</h1>
          <button wire:click='ClearData()' type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="actionForm()">
          <div class="modal-body">
            <div class="mb-2">
              <div>
                <label for="fullname" class="form-label m-0">Nama Lengkap:</label>
                <input type="text" class="form-control" id="fullname" placeholder="Masukkan nama lengkap">
              </div>
              {{-- @error('fullname')
              <span class="text-danger">{{ $message }}</span>
              @enderror --}}
            </div>

            
            <livewire:components.select-with-search />
          </div>
          <div class="modal-footer">
            <button wire:click='ClearData()' type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
