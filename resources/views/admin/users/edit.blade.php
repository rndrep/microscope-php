@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
    {{Form::open(['route'=>['users.update',$item->id], 'method'=>'put'])}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Изменение пользователя</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">

          <div class="col-md-6">
            <div class="form-group">
              <label for="inputName">Фамилия</label>
              <input type="text" class="form-control" name="last_name" placeholder="" value="{{$item->last_name}}">
              <label for="inputDesc">Имя</label>
              <input type="text" class="form-control" name="first_name" placeholder="" value="{{$item->first_name}}">
              <label for="inputDesc">Отчество</label>
              <input type="text" class="form-control" name="patronymic" placeholder="" value="{{$item->patronymic}}">
              <label for="inputDesc">Логин</label>
              <input type="text" class="form-control" name="login" placeholder="" value="{{$item->login}}">
              <label for="inputDesc">Почта</label>
              <input type="text" class="form-control" name="email" placeholder="" value="{{$item->email}}">
              <label for="inputDesc">Пароль</label>
              <input type="text" class="form-control" name="password" placeholder="без изменений">
              <label for="inputDesc">Роль</label>
                {{Form::select(
                    'role_id',
                    $roleIds,
                    $item->getRoleId(),
                    ['class' => 'form-control select2', 'data-placeholder'=>'Выберите роль'])
                }}
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-default">Назад</button>
          <button class="btn btn-warning pull-right">Изменить</button>
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
