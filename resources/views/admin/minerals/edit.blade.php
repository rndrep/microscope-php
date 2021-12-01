@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    {{Form::open(['route'=>['minerals.update',$item->id], 'method'=>'put', 'enctype' => 'multipart/form-data'])}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Изменение минерала</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
              <div class="form-group">
                  <label for="inputPhoto">Картинка</label>
                  <img src="{{$item->getPhoto()}}" alt="" class="row img-responsive" width="200">
                  <input type="file" id="inputPhoto" name="photo">
                  {{--                <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo" style="display:none"></label>--}}
                  <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
              </div>
            <div class="form-group">
              @include('admin.input-microscope')
            </div>
            <div class="form-group">
              @include('admin.input-gallery')
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
                     value="{{$item->{$field->getProp()} }}"
                     {{$field->getType() == 'number' ? 'step=any' : ''}}
              >
            </div>
            @endforeach
            <div class="form-group">
              <label>Сингония</label>
              {{Form::select('syngony_id',
                $syngonyItems,
                $item->getDictionaryPropId('mineralSyngony'),
                ['class' => 'form-control select2', 'placeholder'=>'-'])
              }}
            </div>
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
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->

      </div>
      <!-- /.box -->
    {{Form::close()}}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
