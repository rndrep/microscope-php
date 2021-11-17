@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Минералы</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('minerals.create')}}" class="btn btn-success">Добавить</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
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
                      {{Form::open(['route'=>['minerals.destroy', $item->id], 'method'=>'delete', 'class' => 'd-inline'])}}
                        <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                         <i class="fa fa-trash-alt"></i>
                        </button>
                      {{Form::close()}}
                      @endif
                    </td>
                    <td>{{$item->id}}</td>
                    @foreach($fields as $field)
                      <td>{{$item->{$field->getProp()} }}</td>
                    @endforeach
                    <td>{{$item->getDictionaryPropName('mineralSyngony')}}</td>
                    <td>{{$item->getDictionaryPropName('mineralSplitting')}}</td>
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
