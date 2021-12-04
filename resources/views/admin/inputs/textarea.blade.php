@extends('admin.inputs.layout')

@section('content')
<textarea class="editor" name="{{$prop}}"
  @if($isRequired)
    required
    oninvalid="this.setCustomValidity('{{ $requiredTip }}')"
    oninput="setCustomValidity('')"
  @endif
>
  {!! $value !!}
</textarea>
@endsection
