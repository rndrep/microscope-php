@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col">
          <!-- Card -->
          <div class="card mt-3">

            <div class="card-header">
              <h3>{{$entityCaption}}</h3>
            </div>

            <div class="card-body">
              <div class="form-group">
              <!-- Add and remove buttons are hidden because of filter dependency - DictionaryController::matchDict
                 Dict matching is hardcoded, so the added dict will not be matched
               -->
                <a href="{{route('dict_edit_view', ['entity' => $entityName])}}"
                   class="btn btn-success"
                   @if($isAddHidden)
                    style="display: none"
                   @endif
                >
                  Добавить
                </a>
              <!-- -->
              </div>
              <table class="table table-responsive table-hover dataTable text-center">
                <thead>
                  <tr>
                    <th>Действия</th>
                    <th>ID</th>
                    @foreach($fields as $field)
                    <th>{{$field->getCaption()}}</th>
                    @endforeach
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                  <tr>
                    <td>
                      <div class="btn btn_i">
                        <a href="{{route('dict_edit_view', ['entity' => $entityName, 'id' => $item->id])}}">
                          <svg class="admin-icon edit-icon">
                            <use href="/svg/sprite.svg#edit"></use>
                          </svg>
                        </a>
                      </div>
                      <!-- commented because of filter dependency - DictionaryController::matchDict
                      {{Form::open(['route'=>['dict_destroy', ['entity' => $entityName, 'id' => $item->id]],
                      'method'=>'delete', 'class' => 'd-inline'])}}
                      <button class="btn btn_i" onclick="return confirm('Вы уверены?')" type="submit" class="delete">
                        <svg class="admin-icon trash-icon">
                          <use href="/svg/sprite.svg#trash"></use>
                        </svg>
                      </button>
                      {{Form::close()}}
                      -->
                    </td>
                    <td>{{$item->id}}</td>
                    @foreach($fields as $field)
                    <td>{{$item->{$field->getProp()} }}</td>
                    @endforeach
                  </tr>
                  @endforeach

                  </tfoot>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
