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
              <h3>Минералы</h3>

            </div>
            <div class="card-body">
              <div class="form-group">
                <a href="{{ route('minerals.create') }}" class="btn btn-success">Добавить</a>
              </div>
              <div class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">
                    <table id="dataTable"
                      class="display dtr-inline collapsed nowrap table table-responsive dt-responsive table-hover dataTable text-center"
                      style="width:100%">
                      <thead>
                        <tr>
                          <th>Действия</th>
                          <th>ID</th>
                          @foreach($fields as $field)
                          <th>{{$field->getCaption()}}</th>
                          @endforeach
                          <th>Класс/подкласс</th>
                          <th>Облик кристаллов</th>
                          <th>Блеск</th>
                          <th>Сингония</th>
                          <th>Спайность</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($items as $item)
                        <tr>
                          <td>
                            <div class="btn btn_i">
                              <a href="{{route('minerals.edit', $item->id)}}">
                                <svg class="admin-icon edit-icon">
                                  <use href="/svg/sprite.svg#edit"></use>
                                </svg>
                              </a>
                            </div>
                            @if(Auth::user()->isAdmin())
                            {{Form::open(['route'=>['minerals.destroy', $item->id], 'method'=>'delete', 'class' =>
                            'd-inline'])}}
                            <button class="btn btn_i"
                              onclick="return confirm('Вы уверены, что хотите удалить образец?')" type="submit"
                              class="delete">
                              <svg class="admin-icon trash-icon">
                                <use href="/svg/sprite.svg#trash"></use>
                              </svg>
                            </button>
                            {{Form::close()}}
                            @endif
                          </td>
                          <td>{{$item->id}}</td>
                          @foreach($fields as $field)
                          <td>{!! $item->{$field->getProp()} !!}</td>
                          @endforeach
                          <td>{{$item->getDictionaryPropName('mineralClass')}}</td>
                          <td>{{$item->getDictionaryPropName('mineralCrystalForm')}}</td>
                          <td>{{$item->getDictionaryPropName('mineralShine')}}</td>
                          <td>{{$item->getDictionaryPropName('mineralSyngony')}}</td>
                          <td>{{$item->getDictionaryPropName('mineralSplitting')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./ Card -->
        </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection
