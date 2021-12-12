@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3>Пользователи</h3>
                        </div>
                        <!-- Card-body -->
                        <div class="card-body">

                            <div class="form-group">
                                <a href="{{route('users.create')}}" class="btn btn-success">Добавить</a>
                            </div>

                            <div class="dataTables_wrapper">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="dataTable"
                                            class="display dtr-inline collapsed nowrap table table-responsive dt-responsive table-hover dataTable text-center"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>ФИО</th>
                                                    <th>Логин</th>
                                                    <th>Почта</th>
                                                    <th>Роль</th>
                                                    <th>Действия</th>
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
                                                            <a href="{{route('users.edit', $item->id)}}"
                                                                class="admin-icon edit-icon"></a>
                                                        </div>
                                                        @if(Auth::user()->id != $item->id)
                                                        {{Form::open(['route'=>['users.destroy', $item->id],
                                                        'method'=>'delete',
                                                        'class' =>
                                                        'd-inline'])}}
                                                        <button class="btn" onclick="return confirm('Вы уверены?')"
                                                            type="submit" class="delete">
                                                            <i class="admin-icon trash-icon"></i>
                                                        </button>
                                                        {{Form::close()}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach

                                                </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.Card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection