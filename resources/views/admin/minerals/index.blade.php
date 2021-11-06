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
{{--                  <th>Название</th>--}}
{{--                  <th>Описание</th>--}}
{{--                  <th>Cостав</th>--}}
{{--                  <th>Класс/подкласс</th>--}}
{{--                  <th>Картинка</th>--}}
{{--                  <th>Разновидности</th>--}}
{{--                  <th>Форма выделения</th>--}}
{{--                  <th>Черта</th>--}}
{{--                  <th>Сингония</th>--}}
{{--                  <th>Облик кристаллов</th>--}}
{{--                  <th>Твердость</th>--}}
{{--                  <th>Удельный вес, г/см3</th>--}}
{{--                  <th>Цвет</th>--}}
{{--                  <th>Цвет черты</th>--}}
{{--                  <th>Блеск</th>--}}
                    @foreach($fields as $name => $prop)
                        <th>{{$name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($minerals as $mineral)
					<tr>
{{--	                  <td>{{$mineral->id}}</td>--}}
{{--	                  <td>{{$mineral->getName()}}</td>--}}
{{--	                  <td>{{$mineral->getDescription()}}</td>--}}
{{--	                  <td>{{$mineral->getComposition()}}</td>--}}
{{--	                  <td>{{$mineral->getClass()}}</td>--}}
{{--	                  <td>{{$mineral->getPhoto()}}</td>--}}
{{--	                  <td>{{$mineral->getVarieties()}}</td>--}}
{{--	                  <td>{{$mineral->getAggregates()}}</td>--}}
{{--	                  <td>{{$mineral->getFeature()}}</td>--}}
{{--	                  <td>{{$mineral->getSyngony()}}</td>--}}
{{--	                  <td>{{$mineral->getCrystalForm()}}</td>--}}
{{--	                  <td>{{$mineral->getHardness()}}</td>--}}
{{--	                  <td>{{$mineral->getSpecificGravity()}}</td>--}}
{{--	                  <td>{{$mineral->getColor()}}</td>--}}
{{--	                  <td>{{$mineral->getFeatureColor()}}</td>--}}
{{--	                  <td>{{$mineral->getShine()}}</td>--}}
	                  <td>
                          <div class="btn">
                              <a href="{{route('minerals.edit', $mineral->id)}}" class="fa fa-pencil-alt"></a>
                          </div>
                          {{Form::open(['route'=>['minerals.destroy', $mineral->id], 'method'=>'delete', 'class' => 'd-inline'])}}
                              <button class="btn" onclick="return confirm('are you sure?')" type="submit" class="delete">
                               <i class="fa fa-trash-alt"></i>
                              </button>
                           {{Form::close()}}
	                   </td>
                        @foreach($fields as $name => $prop)
                        <td>{{$mineral->$prop}}</td>
                        @endforeach
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
