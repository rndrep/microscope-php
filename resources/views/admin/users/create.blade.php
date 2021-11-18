@extends('admin.layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        {{Form::open(['route'=>['users.store']])}}
        <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Добавление пользователя</h3>
                    @include('admin.errors')
                </div>
                <div class="box-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputName">Фамилия</label>
                            <input type="text" class="form-control" name="last_name" placeholder="" value="{{old('last_name')}}">
                            <label for="inputDesc">Имя</label>
                            <input type="text" class="form-control" name="first_name" placeholder="" value="{{old('first_name')}}">
                            <label for="inputDesc">Отчество</label>
                            <input type="text" class="form-control" name="patronymic" placeholder="" value="{{old('patronymic')}}">
                            <label for="inputDesc">Логин</label>
                            <input type="text" class="form-control" name="login" placeholder="" value="{{old('login')}}">
                            <label for="inputDesc">Почта</label>
                            <input type="text" class="form-control" name="email" placeholder="" value="{{old('email')}}">
                            <label for="inputDesc">Пароль</label>
                            <input type="text" class="form-control" name="password" placeholder="">
                            <label for="inputDesc">Роль</label>
                            {{Form::select(
                                'role_id',
                                $roleIds,
                                \App\Models\User::ROLE_USER,
                                ['class' => 'form-control select2', 'data-placeholder'=>'Выберите роль'])
                            }}
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
                    <button class="btn btn-warning pull-right">Добавить</button>
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
