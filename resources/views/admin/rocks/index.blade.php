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
                  <th>Публичный</th>
                  <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->description}}</td>
                  <td>{{$item->getRockTypeName()}}</td>
                  <td>{{$item->getFormingMineralName()}}</td>
                  <td>{{$item->getSecondMineralName()}}</td>
                  <td>{{$item->getAccessoryMineralName()}}</td>
                  <td>
                    <img src="{{$item->getPhoto()}}" alt="" width="100">
                  </td>
                  <td>{{$item->is_public ? 'Да' : 'Нет'}}</td>
                    <td>
                      <div class="btn">
                        <a href="{{route('rocks.edit', $item->id)}}" class="fa fa-pencil-alt"></a>
                      </div>
                      {{Form::open(['route'=>['rocks.destroy', $item->id], 'method'=>'delete', 'class' => 'd-inline'])}}
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
