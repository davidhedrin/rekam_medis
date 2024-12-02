<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif

  <div class="row justify-content-between align-items-center">
    <div class="col-auto mb-2">
      <input wire:model.live="inputSearch" class="form-control" type="search" placeholder="Temukan..." aria-label="Search">
    </div>

    <div class="col-12 col-md-6 mb-2 d-flex justify-content-end">
      <div class="d-flex flex-column flex-md-row w-100">
        <input wire:model.live="startDateSearch" class="form-control mb-2 mb-md-0 me-md-2" type="date" required>
        <input wire:model.live="endDateSearch" class="form-control mb-2 mb-md-0 me-md-2 clear_remove" type="date" required>
        <button wire:click='refreshDateParam()' type="button" class="btn btn-outline-primary ms-2 clear_remove"
          style="line-height: 0">
          <i class='bx bx-refresh fs-4'></i>
        </button>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Nomor Rekam</th>
          <th>Pasien</th>
          <th>Staff</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($loadData as $index => $data)
        <tr>
          <th>{{ $loadData->firstItem() + $index }}</th>
          <td>{{ $data->created_at }}</td>
          <td>
            <a href="{{ route('rekam-medis-detail', ['id' => $data->master_record->id]) }}" target="_blank">
              <u>
                {{ $data->master_record->record_num }}
              </u>
            </a>
          </td>
          <td>{{ $data->master_record->patient_name }}</td>
          <td>{{ $data->master_record->user_name }}</td>
          <td>
            @if ($data->master_record->status == true)
            <span class="badge text-bg-success">Aktif</span>
            @else
            <span class="badge text-bg-secondary">Ditutup</span>
            @endif
          </td>
          <td>
            <a href="javascript:void(0)" wire:click='detailRekamMedis({{ $data->id }})'>
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
    {{ $loadData->links() }}
  </div>


  <div wire:ignore.self class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalDetailLabel">Detail Rekam Medis</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @if ($detailData)
          <div class="row">
            <div class="col-md-12">
              <ul class="list-unstyled mb-2">
                <li>
                  <strong>Nomor Rekam:</strong> {{ $detailData->master_record->record_num }}
                  @if ($detailData->master_record->status == true)
                  <span class="badge text-bg-success">Aktif</span>
                  @else
                  <span class="badge text-bg-secondary">Ditutup</span>
                  @endif
                </li>
                {{-- <li><strong>Dibuat:</strong> {{ $detailData->master_record->created_at ?? '-' }}</li> --}}
                <li><strong>Catatan:</strong> {{ $detailData->master_record->desc ?? '-' }}.</li>
              </ul>
            </div>

            <div class="col-md-6">
              <h6 class="m-0"><i class='bx bx-user-pin fs-5'></i> <u>Pasien</u></h6>
              <ul class="list-unstyled mb-2">
                <li>{{ $detailData->master_record->patient_name }}</li>
                <li>Gender: {{ $detailData->master_record->patient->gender }}</li>
                <li>Gol. Darah: {{ $detailData->master_record->patient->blood_type }}</li>
              </ul>
            </div>

            <div class="col-md-6">
              <h6 class="m-0"><i class='bx bx-group fs-5'></i> <u>Staff Pembuat</u></h6>
              <ul class="list-unstyled mb-2">
                <li>{{ $detailData->master_record->user_name }}</li>
                <li>({{ $detailData->master_record->user->master_role->name }})</li>
              </ul>
            </div>
          </div>

          <hr>
          
          <h6><u>Rekam Medis (SOAP)</u></h6>

          <div class="row">
            <div class="col-md-6">
              <strong>Keluhan:</strong> 
              <p>{{ $detailData->complaint }}</p>
            </div>
            <div class="col-md-6">
              <strong>Pemeriksaan Fisis:</strong> 
              <p>{{ $detailData->physical_exam }}</p>
            </div>
            <div class="col-md-6">
              <strong>Diagnosa:</strong> 
              <p>{{ $detailData->diagnosis }}</p>
            </div>
            <div class="col-md-6">
              <strong>Obat & Saran:</strong> 
              <p>{{ $detailData->medicine_advice }}</p>
            </div>
          </div>
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('open-modal', event => {
      $('#modalDetail').modal('show');
    });
  </script>
</div>