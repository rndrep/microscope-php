@extends('admin.inputs.layout')

@section('content')
<div class="editor ck-content" name="{{$prop}}" @if($isRequired) required
  oninvalid="this.setCustomValidity('{{ $requiredTip }}')" oninput="setCustomValidity('')" @endif>
  {!! $value !!}
</div>
@endsection