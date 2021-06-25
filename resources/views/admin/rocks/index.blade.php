@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Породы</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('rocks.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название</th>
                  <th>Описание</th>
                  <th>Тип породы</th>
                  <th>Породообразующий минерал</th>
                  <th>Вторичный минерал</th>
                  <th>Акцессорный минерал</th>
                  <th>Картинка</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rocks as $rock)
                <tr>
                  <td>{{$rock->id}}</td>
                  <td>{{$rock->name}}</td>
                  <td>{{$rock->description}}</td>
                  <td>{{$rock->getRockTypeName()}}</td>
                  <td>{{$rock->getFormingMineralName()}}</td>
                  <td>{{$rock->getSecondMineralName()}}</td>
                  <td>{{$rock->getAccessoryMineralName()}}</td>
                  <td>
                    <img src="{{$rock->getImage()}}" alt="" width="100">
                  </td>
                  <td>
                      <div class="btn">
                        <a href="{{route('rocks.edit', $rock->id)}}" class="fa fa-pencil-alt"></a>
                      </div>
                      {{Form::open(['route'=>['rocks.destroy', $rock->id], 'method'=>'delete', 'class' => 'd-inline'])}}
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
