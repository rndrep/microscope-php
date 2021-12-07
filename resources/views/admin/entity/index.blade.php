@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{$entityCaption}}</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="form-group">
          <a href="{{route('dict_edit_view', ['entity' => $entityName])}}" class="btn btn-success">Добавить</a>
        </div>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Действия</th>
              <th>ID</th>
              @foreach($fields as $field)
              <th>{{$field->getCaption()}}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>
                <div class="btn btn_i">
                  <a href="{{route('dict_edit_view', ['entity' => $entityName, 'id' => $item->id])}}">
                    <svg class="admin-icon edit-icon">
                      <use href="/svg/sprite.svg#edit"></use>
                    </svg>
                  </a>
                </div>
                {{Form::open(['route'=>['dict_destroy', ['entity' => $entityName, 'id' => $item->id]],
                'method'=>'delete', 'class' => 'd-inline'])}}
                <button class="btn btn_i" onclick="return confirm('Вы уверены?')" type="submit" class="delete">
                  <svg class="admin-icon trash-icon">
                    <use href="/svg/sprite.svg#trash"></use>
                  </svg>
                </button>
                {{Form::close()}}
              </td>
              <td>{{$item->id}}</td>
              @foreach($fields as $field)
              <td>{{$item->{$field->getProp()} }}</td>
              @endforeach
            </tr>
            @endforeach

            </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection