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
          <th>Pasien ID</th>
          <th>Nama</th>
          <th>No HP</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Lahir</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($loadData as $index => $data)
        <tr>
          <th>{{ $loadData->firstItem() + $index }}</th>
          <td>{{ $data->patient_id }}</td>
          <td>{{ $data->fullname }}</td>
          <td>{{ $data->no_hp }}</td>
          <td>{{ $data->gender }}</td>
          <td>{{ $data->birth_date }}</td>
          <td>
            <a wire:click='openDetailData({{ $data->id }})' href="javascript:void(0)">
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
  
  <div wire:ignore.self class="modal fade" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modalAddLabel">Tambah Pasien</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="actionForm()">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6 mb-2">
                <div>
                  <label for="fullname" class="form-label m-0">Nama Lengkap:<span class="text-danger">*</span></label>
                  <input wire:model='fullname' type="text" class="form-control" id="fullname" placeholder="Masukkan nama lengkap">
                </div>
                @error('fullname')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="gender" class="form-label m-0">Jenis Kelamin:<span class="text-danger">*</span></label>
                  <select wire:model='gender' id="gender" class="form-select" aria-label="Default select example">
                    <option value="{{ null }}" selected>Pilih jenis kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="birth_date" class="form-label m-0">Tanggal Lahir:<span class="text-danger">*</span></label>
                  <input wire:model='birth_date' type="date" class="form-control" id="birth_date">
                </div>
                @error('birth_date')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="birth_place" class="form-label m-0">Tempat Lahir:<span class="text-danger">*</span></label>
                  <input wire:model='birth_place' type="text" class="form-control" id="birth_place" placeholder="Masukkan tempat lahir">
                </div>
                @error('birth_place')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="no_hp" class="form-label m-0">No HP:</label>
                  <input wire:model='no_hp' type="text" class="form-control" id="no_hp" placeholder="Masukkan nomor ponsel">
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="blood_type" class="form-label m-0">Golongan Darah:</label>
                  <select wire:model='blood_type' id="blood_type" class="form-select" aria-label="Default select example">
                    <option value="{{ null }}" selected>Pilih golongan darah</option>
                    @foreach ($bloodTypes as $data)
                    <option value="{{ $data['value'] }}">{{ $data['text'] }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="religion" class="form-label m-0">Agama:</label>
                  <select wire:model='religion' id="religion" class="form-select" aria-label="Default select example">
                    <option value="{{ null }}" selected>Pilih agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen Protestan">Kristen Protestan</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                    <option value="Lainnya...">Lainnya...</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div>
                  <label for="address" class="form-label m-0">Alamat</label>
                  <textarea wire:model='address' class="form-control" id="address" rows="1" placeholder="Masukkan alamat rumah"></textarea>
                </div>
              </div>
              <div class="col-md-12 mb-2">
                <div>
                  <label for="desc" class="form-label m-0">Keterangan</label>
                  <textarea wire:model='desc' class="form-control" id="desc" rows="1" placeholder="Masukkan keterangan jika ada"></textarea>
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