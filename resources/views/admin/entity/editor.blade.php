@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-6">
          <div class="card mt-3">
            <!-- Card -->
            {{Form::open(['route' => ['dict_update', ['entity' => $entityName, 'id' => $item->id ?? '']],
            'method'=>'put'])}}
            <div class="card-header">
              <h3>{{$entityCaption . ' - '. (empty($item) ? 'Добавление' : 'Изменение') }}</h3>
              @include('admin.errors')
            </div>
            <div class="card-body">
              <div class="col">
                <div class="form-group">
                  <label for="inputName">Название</label>
                  <input required type="text" class="form-control" id="inputName" name="name"
                    value="{{empty($item) ? '' : $item->name}}">
                  <label for="inputDesc">Описание</label>
                  <div type="text" class="form-control" id="inputDesc" name="description"
                    value="{{empty($item) ? '' : $item->description}}">
                  </div>
                </div>
              </div>
            </div>

            <!-- card-footer-->
            <div class="card-footer">
              <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
              <button class="btn btn-warning pull-right">{{empty($item) ? 'Добавить' : 'Измененить'}}</button>
            </div>
            <!-- /.card-footer-->

            {{Form::close()}}
            <!-- ./ Card -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection