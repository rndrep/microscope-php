@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Классы пород</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('rock-classes.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название</th>
                  <th>Описание</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
					<tr>
	                  <td>{{$item->id}}</td>
	                  <td>{{$item->name}}</td>
	                  <td>{{$item->description}}</td>
	                  <td>
                          <div class="btn">
                              <a href="{{route('rock-classes.edit', $item->id)}}" class="fa fa-pencil-alt"></a>
                          </div>
                          {{Form::open(['route'=>['rock-classes.destroy', $item->id], 'method'=>'delete', 'class' => 'd-inline'])}}
                              <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                               <i class="fa fa-trash-alt"></i>
                              </button>
                           {{Form::close()}}
	                   </td>
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
