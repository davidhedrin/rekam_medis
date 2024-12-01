<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif

  <div class="mb-2">
    <a href="{{ route('rekam-medis') }}" class="d-inline-flex align-items-center items-center">
      <div class="me-1">
        <i class='bx bx-arrow-back fs-5'></i>
      </div>
      <div>
        Kembali
      </div>
    </a>
  </div>
  
  <div class="card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h6><u>Informasi Rekam</u></h6>
          <ul class="list-unstyled mb-2">
            <li>
              <strong>Nomor Rekam:</strong> {{ $recordDatas->record_num }}
              @if ($recordDatas->status == true)
              <span class="badge text-bg-success">Aktif</span>
              @else
              <span class="badge text-bg-secondary">Ditutup</span>
              @endif
            </li>
            <li><strong>Dibuat:</strong> {{ $recordDatas->created_at ?? '-' }}</li>
            <li><strong>Catatan:</strong> {{ $recordDatas->desc ?? '-' }}.</li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6><i class='bx bx-user-pin fs-5'></i> <u>Pasien</u></h6>
          <ul class="list-unstyled mb-2">
            <li>{{ $recordDatas->patient_name }}</li>
            <li>Gender: {{ $recordDatas->patient->gender }}</li>
            <li>Gol. Darah: {{ $recordDatas->patient->blood_type }}</li>
          </ul>
        </div>

        <div class="col-md-3">
          <h6><i class='bx bx-group fs-5'></i> <u>Staff Pembuat</u></h6>
          <ul class="list-unstyled mb-2">
            <li>{{ $recordDatas->user_name }}</li>
            <li>({{ $recordDatas->user->master_role->name }})</li>
            {{-- <li>New York, USA</li> --}}
          </ul>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12 col-md-6 d-flex justify-content-start mb-2 mb-md-0">
          @if ($recordDatas->status == true)
          <button wire:click='confirmStatus({{ $recordDatas->id }})' class="btn btn-success me-2">Selesai</button>
          @endif
          <button wire:click='generatePdf({{ $recordDatas->id }})' class="btn btn-primary">Print <i class='bx bx-printer'></i></button>
        </div>
        @if ($recordDatas->status == true)
        <div class="col-12 col-md-6 d-flex justify-content-md-end justify-content-start">
          <button wire:click='confirmAction({{ $recordDatas->id }})' type="button" class="btn btn-danger">Hapus <i class='bx bx-trash'></i></button>
        </div>
        @endif
      </div>
    </div>
  </div>

  {{-- <hr class="my-3"> --}}
  
  <div class="mb-1 d-flex justify-content-between">
    <div>
      <strong>Daftar Riwayat</strong>
    </div>
    <div>
      @if ($recordDatas->status == true)
      <a wire:click='ClearData()' href="javascript:void(0)" type="button" data-bs-toggle="modal" data-bs-target="#modalAdd">
        Tambah Riwayat <i class='bx bx-plus-circle fs-5'></i>
      </a>
      @endif
    </div>
  </div>
  <hr class="m-0"> 
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Keluhan</th>
          <th>Pemeriksaan Fisis</th>
          <th>Diagnosa</th>
          <th>Obat & Saran</th>
          <th>PIC</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($recordDetails as $index => $data)
        <tr>
          <th>{{ $recordDetails->firstItem() + $index }}</th>
          <td>{{ $data->created_at }}</td>
          <td>{{ $data->complaint }}</td>
          <td>{{ $data->physical_exam }}</td>
          <td>{{ $data->diagnosis }}</td>
          <td>{{ $data->medicine_advice }}</td>
          <td>{{ $data->created_by }}</td>
          <td>
            <a wire:click='openDetailData({{ $data->id }})' href="javascript:void(0)">
              <i class='bx bx-edit-alt fs-5'></i>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center italic">Tidak ada data ditemukan!</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="mt-2">
    {{ $recordDetails->links() }}
  </div>

  <div wire:ignore.self class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAddLabel">Tambah Rekaman</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="actionForm()">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12 mb-2">
                <div>
                  <label for="complaint" class="form-label m-0">Keluhan:<span class="text-danger">*</span></label>
                  <textarea wire:model='complaint' class="form-control" id="complaint" rows="2" placeholder="Masukkan keluhan pasien"></textarea>
                </div>
                @error('complaint')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-12 mb-2">
                <div>
                  <label for="physical_exam" class="form-label m-0">Pemeriksaan Fisis:</label>
                  <textarea wire:model='physical_exam' class="form-control" id="physical_exam" rows="2" placeholder="Masukkan pemeriksaan fisis"></textarea>
                </div>
              </div>
              <div class="col-md-12 mb-2">
                <div>
                  <label for="diagnosis" class="form-label m-0">Diagnosa:</label>
                  <textarea wire:model='diagnosis' class="form-control" id="diagnosis" rows="2" placeholder="Masukkan diagnosa pasien"></textarea>
                </div>
              </div>
              <div class="col-md-12 mb-2">
                <div>
                  <label for="medicine_advice" class="form-label m-0">Obat & Saran:</label>
                  <textarea wire:model='medicine_advice' class="form-control" id="medicine_advice" rows="2" placeholder="Masukkan obat dan saran"></textarea>
                </div>
              </div>
            </div>
            <p class="m-0"><small><i>Field dengan tanda <span class="text-danger">*</span> wajib diisi</i></small></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
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
