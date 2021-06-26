@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Пользователи</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <a href="{{route('users.create')}}" class="btn btn-success">Добавить</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Логин</th>
                            <th>Почта</th>
                            <th>Роль</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->getFullName()}}</td>
                                <td>{{$item->login}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->getRoleName()}}</td>
                                <td>
                                    <div class="btn">
                                        <a href="{{route('users.edit', $item->id)}}" class="fa fa-pencil-alt"></a>
                                    </div>
                                    {{Form::open(['route'=>['users.destroy', $item->id], 'method'=>'delete', 'class' => 'd-inline'])}}
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
