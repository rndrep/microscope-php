@extends('admin.layout')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Образцы</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <div class="form-group">
                <a href="{{route('rocks.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered git config --global user.email "hoshizone@gmail.com"git config -l table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Название</th>
                  <th>Описание</th>
                  <th>Тип</th>
                  <th>Отряд</th>
                  <th>Класс</th>
                  <th>Семейство</th>
                  <th>Вид</th>
                  <th>Текстура</th>
                  <th>Структура</th>
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
                  <td>{{mb_substr($item->description, 0, 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockType', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockSquad', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockClass', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockFamily', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockKind', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockTexture', 30)}}</td>
                  <td>{{$item->getDictionaryPropName('rockStructure', 30)}}</td>
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
{{--                      Move delete button in separated template, add if user has rights --}}
                      @if(Auth::user()->isAdmin())
                      {{Form::open(['route'=>['rocks.destroy', $item->id], 'method'=>'delete', 'class' => 'd-inline'])}}
                          <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                           <i class="fa fa-trash-alt"></i>
                          </button>
	                   {{Form::close()}}
                     @endif
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
