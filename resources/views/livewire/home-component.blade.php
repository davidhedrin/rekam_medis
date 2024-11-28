<div>
  @if (Session::has('msgAlert'))
  @livewire('components.toast-alert')
  @endif

  <div class="row">
    <div class="col-md-4 col-sm-12 mb-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <span class="badge bg-primary me-3 fs-6">{{ $count_patient['patient'] }}</span>
            <div class="mb-0">
              <strong>Total Pasien</strong>
              <div class="m-0"><small>+{{ $count_patient['month'] }} Bulan ini.</small></div>
            </div>
          </div>
          <i class='bx bx-universal-access fs-2'></i>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <span class="badge bg-success me-3 fs-6">{{ $count_med_rec }}</span>
            <div class="mb-0">
              <strong>Rekam Medis</strong>
              <div class="m-0"><small>Rekam medis <a href="{{ route('rekam-medis') }}">disini</a></small></div>
            </div>
          </div>
          <i class='bx bx-book-add fs-2'></i>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-3">
      <div class="card shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <span class="badge bg-info me-3 fs-6">{{ $count_user }}</span>
            <div class="mb-0">
              <strong>Total Staff</strong>
              <div class="m-0"><small>Kelola staff <a href="{{ route('staff') }}">disini</a></small></div>
            </div>
          </div>
          <i class='bx bx-git-repo-forked fs-2'></i>
        </div>
      </div>
    </div>
  </div>

  <hr class="mt-2 mb-4">

  <div wire:ignore class="card">
    <div class="card-header">
      <h5 class="m-0">Catatan Penting</h5>
    </div>
    <div class="card-body">
      <form wire:submit.prevent='submitNotes()'>
        <div class="mb-1">
          <textarea id="textarea_notes" class="form-control" id="userInput" placeholder="Tuliskan catatan penting disini...">
            {{ $conten_notes }}
          </textarea>
        </div>
        <p class="mb-2"><small><i>Maksimal panjang karakter <span id="maxLengthChar"></span></small></p>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

@push('scripts')
  <script>
    const maxChars = 5000;
    $(document).ready(function() {
      document.getElementById('maxLengthChar').innerHTML = maxChars;
      tinymce.init({
        selector: '#textarea_notes',
        height: 320,
        menubar: false,
        plugins: [
          'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
          'insertdatetime', 'media', 'table', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat',
        setup: function (editor) {
          editor.on('change', function () {
            const content = editor.getContent();
            const charCount = content.replace(/<[^>]*>/g, '').length;

            if (charCount > maxChars) {
              const trimmedContent = content.slice(0, maxChars);
              editor.setContent(trimmedContent);
              
              Livewire.dispatch('set_session_limit', { title: 'Gagal Memuat', msg: 'Panjang karakter telah mencapai batas.', status: 'warning' });
            }

            @this.set('conten_notes', content);
            console.log(content);
          });
        },
        license_key: 'gpl'
      });
    });
  </script>
@endpush