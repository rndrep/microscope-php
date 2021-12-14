@extends('admin.layout') @section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Card -->
          <div class="card mt-3">
            {{Form::open([
            'route' => 'rocks.store',
            'enctype' => 'multipart/form-data'
            ])}}
            <div class="card-header">
              <h3>Добавление породы</h3>
              @include('admin.errors')
            </div>
            <!-- Card-body -->
            <div class="card-body">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputName">Название <span class="required-field">*</span></label>
                  <input type="text" class="form-control" id="inputName" placeholder="" name="name"
                    value="{{ old('name') }}" required oninvalid="this.setCustomValidity('Обязательное поле')"
                    oninput="setCustomValidity('')" />
                </div>
                <div class="form-group">
                  <label for="inputName">Описание</label>

                  <div class="editor ck-content" id="inputDescription" placeholder="" name="description"
                    value="{{ old('description') }}"></div>
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
                  {{Form::select('rock_kind_id',
                  $rockKinds,
                  null,
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                </div>
                <div class="form-group">
                  <label>Текстура</label>
                  {{Form::select('rock_texture_id',
                  $rockTextures,
                  null,
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                </div>
                <div class="form-group">
                  <label>Структура</label>
                  {{Form::select('rock_structure_id',
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
                <div class="form-group">
                  <label>Местоположение</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend"> <span class="input-group-text">Координаты </span></div>
                    <input type="text" id="lat" name="y" class="form-control" placeholder="Широта" />
                    <input type="text" id="lng" name="x" class="form-control" placeholder="Долгота" />
                  </div>


                  <div id="adminMap" class="map">

                  </div>
                </div>

                <!-- checkbox -->
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkPublic" name="is_public" />
                    <label class="form-check-label" for="checkPublic">
                      Публичный
                    </label>
                  </div>
                </div>
                <!-- ./ checkbox -->
              </div>
            </div>
            <!-- ./ Card-body -->
            <!-- Card-footer -->
            <div class="card-footer">
              <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
              <button class="btn btn-success pull-right">Добавить</button>
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
