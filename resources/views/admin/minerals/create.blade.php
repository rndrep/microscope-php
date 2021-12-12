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
              <div class="col-md-6">
                @foreach($fields as $field)
                  {!! $field->getHtml() !!}
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
                <!-- checkbox -->
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkPublic" name="is_public">
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
          <!-- Card -->
        </div>
      </div>
    </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection
