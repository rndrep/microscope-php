@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    {{Form::open(['route' => ['dict_update', ['entity' => $entityName, 'id' => $item->id ?? '']], 'method'=>'put'])}}
    <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{empty($item) ? 'Добавление' : 'Изменение'}}</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="inputName">Название</label>
              <input required type="text" class="form-control" id="inputName" name="name" placeholder=""
                     value="{{empty($item) ? '' : $item->name}}">
              <label for="inputDesc">Описание</label>
              <input type="text" class="form-control" id="inputDesc" name="description" placeholder=""
                     value="{{empty($item) ? '' : $item->description}}">
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
          <button class="btn btn-warning pull-right">{{empty($item) ? 'Добавить' : 'Измененить'}}</button>
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
