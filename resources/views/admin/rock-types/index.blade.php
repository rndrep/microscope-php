@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
{{--    <section class="content-header">--}}
{{--      <h1>--}}
{{--        Типы пород--}}
{{--      </h1>--}}
{{--      <ol class="breadcrumb">--}}
{{--        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
{{--        <li><a href="#">Examples</a></li>--}}
{{--        <li class="active">Blank page</li>--}}
{{--      </ol>--}}
{{--    </section>--}}

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Типы пород</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('rock-types.create')}}" class="btn btn-success">Добавить</a>
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
                @foreach($rockTypes as $rockType)
					<tr>
	                  <td>{{$rockType->id}}</td>
	                  <td>{{$rockType->name}}</td>
	                  <td>{{$rockType->description}}</td>
	                  <td>
                          <div class="btn">
                              <a href="{{route('rock-types.edit', $rockType->id)}}" class="fa fa-pencil-alt"></a>
                          </div>
                          {{Form::open(['route'=>['rock-types.destroy', $rockType->id], 'method'=>'delete', 'class' => 'd-inline'])}}
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
