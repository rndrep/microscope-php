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
              <div class="dataTables_wrapper">
                <div class="row">
                  <div class="col-sm-12">
                    <table class="table table-responsive table-bordered table-hover dataTable text-center">
                      <thead>
                        <tr>
                          <th>Действия</th>
                          <th>ID</th>
                          @foreach($fields as $field)
                          <th>{{$field->getCaption()}}</th>
                          @endforeach
                          <th>Сингония</th>
                          <th>Спайность</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($items as $item)
                        <tr>
                          <td>
                            <div class="btn">
                              <a href="{{route('minerals.edit', $item->id)}}" class="fa fa-pencil-alt"></a>
                            </div>
                            @if(Auth::user()->isAdmin())
                            {{Form::open(['route'=>['minerals.destroy', $item->id], 'method'=>'delete', 'class' =>
                            'd-inline'])}}
                            <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                              <i class="fa fa-trash-alt"></i>
                            </button>
                            {{Form::close()}}
                            @endif
                          </td>
                          <td>{{$item->id}}</td>
                          @foreach($fields as $field)
                          <td>{!! $item->{$field->getProp()} !!}</td>
                          @endforeach
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