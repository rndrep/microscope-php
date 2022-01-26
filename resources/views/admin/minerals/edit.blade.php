@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col">

          <!-- Card img-dropzone -->
          <div class="card mt-3">

            <div class="card-header">
              <h3>Добавление изображений</h3>
            </div>

            <div class="card-body">
              <!-- Form add img -->
              <div class="row">
                <div class="col-lg-6">
                  {{--                  <form class="form" action="#" method="post">--}}
                  <div class="form-group">
                    <label class="col-form-label text-lg-right">Загрузка изображения для минерала</label>
                    <form class="dropzone" id="photoDropzone"
                      action="{{ route('media_save', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'info']) }}"
                      data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'info']) }}">
                      <div class="dz-message needsclick">
                        <i class="far fa-image fa-3x text-primary"></i>
                        <!-- Info -->
                        <div class="ml-3">
                          <p class="fs-5 text-muted">Перенесите файл сюда или нажмите
                            для
                            загрузки.
                          </p>
                          <span class="fs-7 mt-0 text-primary form-text opacity-75">Загрузите 1 файл</span>
                        </div>
                        <!-- ./Info -->
                      </div>
                    </form>
                  </div>
                  {{--                  </form>--}}
                </div>
              </div>
              <!-- ./Form add img-->

              <!-- ./Form gallery img-->
              <div class="row">
                <div class="col">
                  {{--                  <form class="form" action="#" method="post">--}}
                  <div class="form-group">
                    <label class="col-form-label text-lg-right">Загрузка изображений для галереи</label>
                    <form class="dropzone dz-clickable" id="galleryDropzone"
                      action="{{ route('media_save', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'gallery']) }}"
                      data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'gallery']) }}">
                      <div class="dz-message needsclick">
                        <i class="far fa-images fa-3x text-primary"></i>
                        <!-- Info -->
                        <div class="ml-3">
                          <p class="fs-5 text-muted">Перенесите файл сюда или нажмите
                            для
                            загрузки.
                          </p>
                          <span class="fs-7 mt-0 text-primary form-text opacity-75">Загрузите до 10 файлов</span>
                        </div>
                        <!-- ./Info -->
                      </div>

                    </form>
                  </div>
                  {{--                  </form>--}}
                </div>
              </div>
              <!-- ./Form add gallery img-->

              <!-- Form micro photos -->
              <div class="row">
                <div class="col">
                  {{--                  <form class="form" action="#" method="post">--}}
                  <!-- Micro photos -->
                  <div class="row">
                    <div class="col-lg-6 form-group">
                      <label class=" col-form-label text-lg-right">Загрузка изображений микроскопа с
                        анализатором</label>

                      <!-- PplDropzone -->
                      <form class="dropzone dropzone-queue mb-2" id="microPplDropzone"
                        action="{{ route('media_save', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'ppl']) }}"
                        data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'ppl']) }}">
                        <div class="dz-message" style="display:none"></div>

                        <!-- Controls -->
                        <div class="dropzone-panel mb-lg-0 mb-2">
                          <a class="dropzone-select btn  btn-primary me-2  mb-1 ">Выбрать файлы</a>
                          <a class="dropzone-upload btn  btn-secondary me-2  mb-1 ">Загрузить все</a>
                          <a class="dropzone-remove-all btn btn-secondary  mb-1 ">Удалить все</a>
                        </div>
                        <!-- ./Controls -->

                        <!-- Items -->
                        <div class="dropzone-items">
                          <div class="dropzone-item" style="display:none">
                            <!--begin::File-->
                            <div class="dropzone-file">
                              <div class="dropzone-filename" title="some_image_file_name.jpg">
                                <span data-dz-name>some_image_file_name.jpg</span>
                                (<span data-dz-size>340kb</span>)
                              </div>

                              <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                              <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                  aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                </div>
                              </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">

                              <span class="dz-remove dropzone-delete" data-dz-remove></span>
                            </div>
                            <!--end::Toolbar-->
                          </div>
                        </div>
                        <!-- ./Items -->

                      </form>
                      <!-- ./PplDropzone-->
                      <span class="form-text text-muted"> Максимальный размер файла 1MB, максимальное количество
                        36.</span>

                    </div>
                    <div class="col-lg-6 form-group">
                      <label class="col-form-label text-lg-right">Загрузка изображений микроскопа без
                        анализатора</label>
                      <!-- XplDropzone -->
                      <form class="dropzone dropzone-queue mb-2" id="microXplDropzone"
                        action="{{ route('media_save', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'xpl']) }}"
                        data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'mineral', 'type' => 'xpl']) }}">
                        <div class="dz-message" style="display:none"></div>

                        <!-- Controls -->
                        <div class="dropzone-panel mb-lg-0 mb-2">
                          <a class="dropzone-select btn  btn-primary me-2 mb-1">Выбрать файлы</a>
                          <a class="dropzone-upload btn  btn-secondary me-2 mb-1">Загрузить все</a>
                          <a class="dropzone-remove-all btn btn-secondary mb-1">Удалить все</a>
                        </div>
                        <!-- ./Controls -->

                        <!-- Items -->
                        <div class="dropzone-items">
                          <div class="dropzone-item" style="display:none">
                            <!--begin::File-->
                            <div class="dropzone-file">
                              <div class="dropzone-filename" title="some_image_file_name.jpg">
                                <span data-dz-name>some_image_file_name.jpg</span>
                                (<span data-dz-size>340kb</span>)
                              </div>

                              <div class="dropzone-error" data-dz-errormessage></div>
                            </div>
                            <!--end::File-->

                            <!--begin::Progress-->
                            <div class="dropzone-progress">
                              <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0"
                                  aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                </div>
                              </div>
                            </div>
                            <!--end::Progress-->

                            <!--begin::Toolbar-->
                            <div class="dropzone-toolbar">
                              <span class="dz-remove dropzone-delete" data-dz-remove></span>
                            </div>
                            <!--end::Toolbar-->
                          </div>
                        </div>
                        <!-- ./Items -->

                      </form>
                      <!-- ./XplDropzone-->
                      <span class="form-text text-muted"> Максимальный размер файла 1MB, максимальное количество
                        36.</span>
                    </div>
                  </div>
                  <!-- ./Micro photos -->
                  {{--                  </form>--}}
                </div>
              </div>
              <!-- ./Form micro photos -->

            </div>
          </div>
        </div>
        <!-- ./ Card img-dropzone -->
      </div>

      <!-- Card change info -->
      <div class="row">
        <div class="col">
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
              <div class="row row-cols-1 row-cols-lg-2">
                <!-- TODO: Где шаблон?? -->
                @foreach($fields as $field)
                {!! $field->getHtml() !!}
                @endforeach

                <div class="col">
                  <div class="form-group">
                    <label>Класс/подкласс</label>
                    {{Form::select('mineral_class_id',
                  $classItems,
                  $item->getDictionaryPropId('mineralClass'),
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Облик кристаллов</label>
                    {{Form::select('mineral_crystal_form_id',
                  $crystalFormItems,
                  $item->getDictionaryPropId('mineralCrystalForm'),
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Блеск</label>
                    {{Form::select('mineral_shine_id',
                  $shineItems,
                  $item->getDictionaryPropId('mineralShine'),
                  ['class' => 'form-control select2', 'placeholder'=>'-'])
                  }}
                  </div>
                </div>

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

              <!-- Map and checkbox -->
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <div class="form-group">
                      <label>Местоположение</label>
                      <div class="input-group mb-3">
                        <input type="number" step="any" id="lat" name="y" value="{{$item->y}}" class="form-control"
                          placeholder="Широта" />
                        <input type="number" step="any" id="lng" name="x" value="{{$item->x}}" class="form-control"
                          placeholder="Долгота" />
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="button" id="btnMap">Показать</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div id="adminMap" class="map mb-3">
                  </div>
                </div>

                <div class="col">
                  <!-- Checkbox -->
                  <div class="form-group">
                    <label>Доступ</label>
                    <div class="input-group mb-3">
                      <div class="form-check">
                        {{Form::checkbox('is_public', '1', $item->isPublic(),
                        ['class'=>'form-check-input', 'id'=>'checkPublic'])}}
                        <label class="form-check-label" for="checkPublic">
                          Публичный
                        </label>
                      </div>
                    </div>

                  </div>
                  <!-- ./ Checkbox -->
                </div>
              </div>
              <!-- ./ Map and checkbox -->
            </div>
            <!-- Card-body -->

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
      </div>
      <!-- ./ Card change info -->

    </div>

</div>
</section>
<!-- ./ Main content -->
</div>
@endsection
