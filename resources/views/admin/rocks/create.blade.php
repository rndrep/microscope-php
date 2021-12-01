@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  {{--
  <!-- Content Header (Page header) -->--}}
  {{-- <section class="content-header">--}}
    {{-- <h1>--}}
      {{-- Добавить статью--}}
      {{-- <small>приятные слова..</small>--}}
      {{-- </h1>--}}
    {{-- </section>--}}

  <!-- Main content -->
  <section class="content">
    {{Form::open([
    'route' => 'rocks.store',
    'enctype' => 'multipart/form-data'
    ])}}
    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Добавление образца</h3>
        @include('admin.errors')
      </div>
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="inputPhoto">Картинка</label>
            <input type="file" id="inputPhoto" name="photo">
            {{-- <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo"
                style="display:none"></label>--}}
            <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
          </div>
          <div class="form-group">
            @include('admin.input-microscope')
          </div>
          <div class="form-group">
            <label for="inputName">Название *</label>
            <input type="text" class="form-control" id="inputName" placeholder="" name="name" value="{{old('name')}}"
              required oninvalid="this.setCustomValidity('Обязательное поле')" oninput="setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="inputName">Описание</label>

            <textarea class="ck-content" name="descriptionEditor" id="descriptionEditor"></textarea>

            <input type="text" class="editor form-control" id="inputDescription" placeholder="" name="description"
              value="{{old('description')}}"> </input>
          </div>
          <div class="form-group">
            <label>Тип породы</label>
            {{Form::select('rock_type_id',
            $rockTypes,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Класс</label>
            {{Form::select('rock_class_id',
            $rockClasses,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Отряд</label>
            {{Form::select('rock_squad_id',
            $rockSquads,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Семейство</label>
            {{Form::select('rock_family_id',
            $rockFamilies,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Вид</label>
            {{Form::select('rock_family_id',
            $rockKinds,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Текстура</label>
            {{Form::select('rock_family_id',
            $rockTextures,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
            }}
          </div>
          <div class="form-group">
            <label>Структура</label>
            {{Form::select('rock_family_id',
            $rockStructures,
            null,
            ['class' => 'form-control select2', 'placeholder'=>'-'])
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
          <div class="form-group">
            <label>Окаменелости</label>
            {{Form::select('fossils[]',
            $fossils,
            null,
            ['class' => 'form-control select2', 'multiple'=>'multiple', 'data-placeholder'=>'Выберите окаменелости'])
            }}
          </div>
          <!-- Date -->
          {{-- <div class="form-group">--}}
            {{-- <label>Дата:</label>--}}

            {{-- <div class="input-group date">--}}
              {{-- <div class="input-group-addon">--}}
                {{-- <i class="fa fa-calendar"></i>--}}
                {{-- </div>--}}
              {{-- <input type="text" class="form-control pull-right" id="datepicker" name="date"
                value="{{old('date')}}">--}}
              {{-- </div>--}}
            {{--
            <!-- /.input group -->--}}
            {{--
          </div>--}}

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
        <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
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