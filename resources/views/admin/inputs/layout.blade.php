<div class="col">
  <div class="form-group">
    <label for="inputName">{{$caption}}
      @if($isRequired)
        <span class="required-field">*</span>
      @endif
    </label>
    @yield('content')
  </div>
</div>
