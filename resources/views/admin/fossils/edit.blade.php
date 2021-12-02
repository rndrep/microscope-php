@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Card -->
          <div class="card mt-3">
            {!! Form::open(['route' => ['fossils.update', $item->id], 'method'=>'put', 'enctype' =>
            'multipart/form-data']) !!}
            <div class="card-header">
              <h3>Изменение окаменелости</h3>
              @include('admin.errors')
            </div>

            <!-- Card-body -->
            <div class="card-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputPhoto">Картинка</label>
                  <div>
                    <img src="{{$item->getPhoto()}}" alt="" class="row img-responsive" width="200">
                    <input type="file" id="inputPhoto" name="photo">
                    <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
                  </div>
                </div>
                <div class="form-group">
                  @include('admin.input-gallery')
                </div>
                @foreach($fields as $field)
                <div class="form-group">
                  <label for="inputName">{{$field->getCaption()}}</label>
                  <input type="{{$field->getType()}}" class="form-control" placeholder="" name="{{$field->getProp()}}"
                    @if($field->getRequired())
                  required
                  oninvalid="this.setCustomValidity('{{ $field->getRequiredTip() }}')"
                  oninput="setCustomValidity('')"
                  @endif
                  value="{{$item->{$field->getProp()} }}"
                  {{$field->getType() == 'number' ? 'step=any' : ''}}
                  >
                </div>
                @endforeach
                <div class="form-group">
                  <label>Типы беспозвоночных животных</label>
                  {{Form::select('invertebrate_id',
                  $invertebrates,
                  $item->getDictionaryPropId('invertebrate'),
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                </div>
                <div class="form-group">
                  <label>Руководящие формы</label>
                  {{Form::select('index_fossil_id',
                  $indexFossils,
                  $item->getDictionaryPropId('indexFossil'),
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                </div>
              </div>
            </div>
            <!-- ./ Card-body -->

            <!-- Card-footer -->
            <div class="card-footer">
              <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
              <button class="btn btn-success pull-right">Изменить</button>
            </div>
            <!-- ./ Card-footer -->
            {!! Form::close() !!}
          </div>
          <!-- ./ Card -->
        </div>
      </div>
    </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection