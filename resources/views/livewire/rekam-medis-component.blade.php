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
          <th>Status</th>
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
          <td><strong class="text-success">{{ $data->record_detail_count }}</strong> Rekaman</td>
          <td>
            @if ($data->status == true)
            <span class="badge text-bg-success">Aktif</span>
            @else
            <span class="badge text-bg-secondary">Ditutup</span>
            @endif
          </td>
          <td>
            <a href="{{ route('rekam-medis-detail', ['id' => $data->id]) }}">
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
              <label for="fullname" class="form-label m-0">Pilih Pasien:</label>
              <div class="dropdown">
                <button class="btn btn-search-select-dropdown" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  @if ($selectedPatient)
                  {{ $selectedPatient->fullname }}
                  @else
                  Pilih Opsi
                  @endif
                  <i class="bi bi-chevron-down ms-2"></i>
                </button>
                <div wire:ignore.self class="dropdown-menu search-select-dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                  <input wire:model='searchPatient' wire:input.debounce.400ms='LoadListPatient()' type="text" class="search-select-dropdown" id="searchInput" placeholder="Cari opsi...">
                  @forelse ($listPatient as $data)
                  <a wire:click='onchangeSelectPatient({{ $data }})' class="dropdown-item" href="javascript:void(0)">{{ $data->fullname }}</a>
                  @empty
                  <span class="dropdown-item" style="cursor: default"><i><small>"{{ $searchPatient }}" tidak ditemukan</small></i></span>
                  @endforelse
                </div>
              </div>
              @error('patient_id')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div>
              <label for="fullname" class="form-label m-0">Keterangan:</label>
              <textarea wire:model='desc' class="form-control" placeholder="Masukkan keterangan jika ada" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button wire:click='ClearData()' type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Mulai Rekam</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('close-form-modal', event => {
      $('#modalAdd').modal('hide');
      $('#modalEdit').modal('hide');
      $('#modalDelete').modal('hide');
    });
    window.addEventListener('open-edit-modal', event => {
      $('#modalAdd').modal('show');
    });
  </script>
</div>