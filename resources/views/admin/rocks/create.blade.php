@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
{{--    <!-- Content Header (Page header) -->--}}
{{--    <section class="content-header">--}}
{{--      <h1>--}}
{{--        Добавить статью--}}
{{--        <small>приятные слова..</small>--}}
{{--      </h1>--}}
{{--    </section>--}}

    <!-- Main content -->
    <section class="content">
	{{Form::open([
		'route'	=> 'rocks.store',
		'files'	=>	true
	])}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавление породы</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="inputName">Название *</label>
              <input type="text" class="form-control" id="inputName" placeholder="" name="name" value="{{old('name')}}">
            </div>
            <div class="form-group">
              <label for="inputName">Описание</label>
              <input type="text" class="form-control" id="inputDescription" placeholder="" name="description" value="{{old('description')}}">
            </div>
            <div class="form-group">
              <label for="inputPhoto">Картинка</label>
              <input type="file" id="inputPhoto" name="photo">
{{--                <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo" style="display:none"></label>--}}
              <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
            </div>
            <div class="form-group">
              <label>Тип породы</label>
              {{Form::select('rock_type_id',
              	$rockTypes,
              	null,
              	['class' => 'form-control select2', 'data-placeholder'=>'Выберите тип породы'])
              }}
            </div>
            <div class="form-group">
              <label>Породообразующие минералы</label>
              {{Form::select('forming_minerals[]',
                $minerals,
                null,
                ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите минералы'])
              }}
            </div>
            <div class="form-group">
              <label>Вторичные минералы</label>
              {{Form::select('second_minerals[]',
                $minerals,
                null,
                ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите минералы'])
              }}
            </div>
            <div class="form-group">
            <label>Акцессорные минералы</label>
              {{Form::select('accessory_minerals[]',
                $minerals,
                null,
                ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите минералы'])
              }}
            </div>
            <!-- Date -->
{{--            <div class="form-group">--}}
{{--              <label>Дата:</label>--}}

{{--              <div class="input-group date">--}}
{{--                <div class="input-group-addon">--}}
{{--                  <i class="fa fa-calendar"></i>--}}
{{--                </div>--}}
{{--                <input type="text" class="form-control pull-right" id="datepicker" name="date" value="{{old('date')}}">--}}
{{--              </div>--}}
{{--              <!-- /.input group -->--}}
{{--            </div>--}}

            <!-- checkbox -->
            <div class="form-group">
              <label>
                <input type="checkbox" class="minimal" name="is_public">
              </label>
              <label>
                Публичный
              </label>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button class="btn btn-success pull-right">Добавить</button>
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
