@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Минералы</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('minerals.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Действия</th>
                  <th>ID</th>
                  @foreach($fields as $name => $prop)
                      <th>{{$name}}</th>
                  @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($minerals as $mineral)
					        <tr>
	                  <td>
                      <div class="btn">
                          <a href="{{route('minerals.edit', $mineral->id)}}" class="fa fa-pencil-alt"></a>
                      </div>
                      {{Form::open(['route'=>['minerals.destroy', $mineral->id], 'method'=>'delete', 'class' => 'd-inline'])}}
                          <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                           <i class="fa fa-trash-alt"></i>
                          </button>
                       {{Form::close()}}
                    </td>
                    <td>{{$mineral->id}}</td>
                    @foreach($fields as $name => $prop)
                      <td>{{$mineral->$prop}}</td>
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
