@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        {!! Form::open(['route' => ['fossils.update', $item->id], 'method'=>'put', 'enctype' => 'multipart/form-data']) !!}
        <div class="box-header with-border">
          <h3 class="box-title">Добавление окаменелости</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
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
                <input type="{{$field->getType()}}" class="form-control" placeholder=""
                       name="{{$field->getProp()}}"
                       @if($field->getRequired())
                        required
                        oninvalid="this.setCustomValidity('{{ $field->getRequiredTip()  }}')"
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
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
          <button class="btn btn-success pull-right">Измменить</button>
        </div>
        <!-- /.box-footer-->
        {!! Form::close() !!}
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
