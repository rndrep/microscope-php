@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
        {!! Form::open(['route' => 'minerals.store', 'enctype' => 'multipart/form-data']) !!}
        <div class="box-header with-border">
          <h3 class="box-title">Добавление минерала</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="inputPhoto">Картинка</label>
              <div>
                <input type="file" id="inputPhoto" name="photo">
                {{--                <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo" style="display:none"></label>--}}
                <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
              </div>
            </div>
            <div class="form-group">
              @include('admin.input-microscope')
            </div>
            @foreach($fields as $field)
              <div class="form-group">
                <label for="inputName">{{$field->getCaption()}}</label>
                <input type="{{$field->getType()}}" class="form-control" id="inputName" placeholder=""
                      name="{{$field->getProp()}}"
                      @if($field->getRequired())
                        required
                        oninvalid="this.setCustomValidity('{{ $field->getRequiredTip()  }}')"
                        oninput="setCustomValidity('')"
                      @endif
                      {{$field->getType() == 'number' ? 'step=any' : ''}}
                >
              </div>
            @endforeach
            <div class="form-group">
              <label>Сингония</label>
              {{Form::select('syngony_id',
                $syngonyItems,
                null,
                ['class' => 'form-control select2', 'placeholder'=>'-'])
              }}
            </div>
            <div class="form-group">
              <label>Спайность</label>
              {{Form::select('splitting_id',
                $splittingItems,
                null,
                ['class' => 'form-control select2', 'placeholder'=>'-'])
              }}
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button class="btn btn-success pull-right">Добавить</button>
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
