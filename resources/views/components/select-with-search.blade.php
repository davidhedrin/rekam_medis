<div>
  <select class="form-control search-dropdown">
      <option value="">Pilih opsi...</option>
      @foreach($options as $key => $option)
          <option value="{{ $key }}">{{ $option }}</option>
      @endforeach
  </select>
</div>