@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Card -->
          <div class="card mt-3">
            <div class="card-header">
              <h3>Породы</h3>
            </div>
            <div class="card-body">
              <div class="form-group">
                <a href="{{route('rocks.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <div class="dataTables_wrapper">
                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-responsive table-bordered table-hover dataTable text-center">
                      <thead>
                        <tr>
                          <th>Действия</th>
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
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($items as $item)
                        <tr>
                          <td>
                            <div class="btn">
                              <a href="{{route('rocks.edit', $item->id)}}" class="fa fa-pencil-alt"></a>
                            </div>
                            {{-- Move delete button in separated template, add if user has rights --}}
                            @if(Auth::user()->isAdmin())
                            {{Form::open(['route'=>['rocks.destroy', $item->id], 'method'=>'delete', 'class' =>
                            'd-inline'])}}
                            <button class="btn" onclick="return confirm('Вы действительно хотите удалить образец?')"
                              type="submit" class="delete">
                              <i class="fa fa-trash-alt"></i>
                            </button>
                            {{Form::close()}}
                            @endif
                          </td>
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
                        </tr>
                        @endforeach
                        </tfoot>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./ Card -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection