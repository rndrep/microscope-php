@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Card -->
          <div class="card mt-3">
            {{Form::open(['route'=>['minerals.update',$item->id], 'method'=>'put', 'enctype' =>
            'multipart/form-data'])}}

            <div class="card-header">
              <h3>Изменение минерала</h3>
              @include('admin.errors')
            </div>

            <!-- Card-body -->
            <div class="card-body">
              <div class="row">
                <!-- Photo -->
                <div class="col-4">
                  <div class="form-group">
                    <label for="inputPhoto">Картинка</label>
                    <!-- <img src="{{$item->getPhoto()}}" alt="" class="card-img img-responsive"> -->
                    <div type="file" class="dropzone" id="photoDropzone" name="photo">
                      <div class="dz-message needsclick">
                        <div <p>Перенесите файл сюда или нажмите для загрузки
                          </p>
                          <span>Загрузите 1 файл</span>
                        </div>
                      </div>
                    </div>

                    {{-- <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto" name="photo"
                        style="display:none"></label>--}}
                    </input>
                  </div>
                </div>
                <!-- ./ Photo -->

                <!-- Gallery -->
                <div class="col-8">
                  <div class="form-group">
                    @include('admin.input-gallery')
                    <div type="file" class="dropzone" id="galleryDropzone" name="gallery">
                      <div class="d-flex justify-content-center"> <a
                          class="dropzone-remove-all btn btn-sm btn-outline-dark">
                          Удалить все
                        </a></div>
                      <div class="dz-message needsclick">
                        <div <p>Перенесите файлы сюда или нажмите для загрузки
                          </p>
                          <span>Загрузите до 10 файлов</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ./ Gallery -->
              </div>


              <div class="row justify-content-center">
                <div class="col">
                  <!-- Micro-photos -->
                  <div class="form-group">
                    @include('admin.input-microscope')
                    <p>PPL</p>
                    <div type="file" class="dropzone microDropzone" name="photo">
                    </div>
                    <p>XPL</p>
                    <div type="file" class="dropzone microDropzone" name="photo">
                    </div>
                  </div>
                  <!-- ./ Micro-photos -->
                </div>
              </div>

              <div class="row row-cols-1 row-cols-lg-2">
                <!-- TODO: Где шаблон?? -->
                @foreach($fields as $field)
                <div class="col">
                  <div class="form-group">
                    <label class="card-title" for="inputName">{{$field->getCaption()}}</label>
                    <input type="{{$field->getType()}}" class="form-control" id="inputName" placeholder=""
                      name="{{$field->getProp()}}" @if($field->getRequired())
                    required
                    oninvalid="this.setCustomValidity('{{ $field->getRequiredTip() }}')"
                    oninput="setCustomValidity('')"
                    @endif
                    value="{{$item->{$field->getProp()} }}"
                    {{$field->getType() == 'number' ? 'step=any' : ''}}
                    >

                  </div>
                </div>
                @endforeach
                <div class="col">
                  <div class="form-group">
                    <label>Сингония</label>
                    {{Form::select('syngony_id',
                    $syngonyItems,
                    $item->getDictionaryPropId('mineralSyngony'),
                    ['class' => 'form-control select2', 'placeholder'=>'-'])
                    }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Спайность</label>
                    {{Form::select('splitting_id',
                    $splittingItems,
                    $item->getDictionaryPropId('mineralSplitting'),
                    ['class' => 'form-control select2', 'placeholder'=>'-'])
                    }}
                  </div>
                </div>
              </div>
              <!-- Card-body -->
            </div>
          </div>
          <!-- Card-footer -->
          <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
            <button class="btn btn-warning pull-right">Изменить</button>
          </div>
          <!-- ./ Card-footer -->
          {!! Form::close() !!}
        </div>
        <!-- ./ Card -->

      </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection