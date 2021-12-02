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
            {{Form::open(['route'=>['minerals.update',$item->id], 'method'=>'put', 'enctype' =>
            'multipart/form-data'])}}

            <div class="card-header">
              <h3>Изменение минерала</h3>
              @include('admin.errors')
            </div>

            <!-- Card-body -->
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label class="card-title" for="inputPhoto">Картинка</label>
                    <img src="{{$item->getPhoto()}}" alt="" class="row card-img img-responsive" width="200">
                    <input type="file" id="inputPhoto" name="photo">
                    {{-- <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo"
                        style="display:none"></label>--}}
                    <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    @include('admin.input-microscope')
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    @include('admin.input-gallery')
                  </div>
                </div>
              </div>

              <div class="row row-cols-1 row-cols-lg-2">
                <!-- TODO: Где шаблон?? -->
                @foreach($fields as $field)
                <div class="col">
                  <div class="form-group">
                    <label class="card-title" for="inputName">{{$field->getCaption()}}</label>
                    <input type="{{$field->getType()}}" class="form-control" id="inputName" placeholder=""
                      name="{{$field->getProp()}}" @if($field->getRequired())
                    required
                    oninvalid="this.setCustomValidity('{{ $field->getRequiredTip() }}')"
                    oninput="setCustomValidity('')"
                    @endif
                    value="{{$item->{$field->getProp()} }}"
                    {{$field->getType() == 'number' ? 'step=any' : ''}}
                    >

                  </div>
                </div>
                @endforeach
                <div class="col">
                  <div class="form-group">
                    <label>Сингония</label>
                    {{Form::select('syngony_id',
                    $syngonyItems,
                    $item->getDictionaryPropId('mineralSyngony'),
                    ['class' => 'form-control select2', 'placeholder'=>'-'])
                    }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Спайность</label>
                    {{Form::select('splitting_id',
                    $splittingItems,
                    $item->getDictionaryPropId('mineralSplitting'),
                    ['class' => 'form-control select2', 'placeholder'=>'-'])
                    }}
                  </div>
                </div>
              </div>
              <!-- Card-body -->
            </div>
            <!-- Card-footer -->
            <div class="card-footer">
              <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
              <button class="btn btn-warning pull-right">Изменить</button>
            </div>
            <!-- ./ Card-footer -->
            {!! Form::close() !!}

            <!-- ./ Card -->
          </div>
        </div>
      </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection