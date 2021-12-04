@extends('admin.inputs.layout')

@section('content')
<input type="{{ $type }}" class="form-control" placeholder="" name="{{ $prop }}"
  @if($isRequired)
    required
    oninvalid="this.setCustomValidity('{{ $requiredTip }}')"
    oninput="setCustomValidity('')"
  @endif
  {{$type == 'number' ? 'step=any' : ''}}
>
@endsection
