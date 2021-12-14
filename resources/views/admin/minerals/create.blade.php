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
            {!! Form::open(['route' => 'minerals.store', 'enctype' => 'multipart/form-data']) !!}
            <div class="card-header">
              <h3>Добавление минерала</h3>
              @include('admin.errors')
            </div>
            <!-- Card-body -->

            <div class="card-body">
              <div class="row row-cols-1 row-cols-lg-2">
                @foreach($fields as $field)
                {!! $field->getHtml() !!}
                @endforeach
                <div class="col">
                  <div class="form-group">
                    <label>Сингония</label>
                    {{Form::select('syngony_id',
                  $syngonyItems,
                  null,
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                  </div>
                </div>
                <div class="col">
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

              <!-- Map and checkbox -->
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <div class="form-group">
                      <label>Местоположение</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend"> <span class="input-group-text">Координаты </span></div>
                        <input type="text" id="lat" name="y" class="form-control" placeholder="Широта" />
                        <input type="text" id="lng" name="x" class="form-control" placeholder="Долгота" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div id="adminMap" class="map mb-3">
                  </div>
                </div>
                <div class="col">
                  <!-- Checkbox -->
                  <div class="form-group">
                    <label>Доступ</label>
                    <div class="input-group mb-3">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkPublic" name="is_public" <label
                          class="form-check-label" for="checkPublic">
                        Публичный
                        </label>
                      </div>
                    </div>

                  </div>
                  <!-- ./ Checkbox -->
                </div>

              </div>
              <!-- ./ Map and checkbox -->
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
          <!-- Card -->
        </div>
      </div>
    </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection
