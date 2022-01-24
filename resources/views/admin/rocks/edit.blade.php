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
                  <div class="form-group">
                    <label class="col-form-label text-lg-right">Загрузка изображения для породы</label>
                    <form class="dropzone" id="photoDropzone"
                      action="{{ route('media_save', ['id' => $item->id, 'entity' => 'rock', 'type' => 'info']) }}"
                      data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'rock', 'type' => 'info']) }}">
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
                </div>
              </div>
              <!-- ./Form add img-->

              <!-- ./Form gallery img-->
              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="col-form-label text-lg-right">Загрузка изображений для галереи</label>
                    <form class="dropzone dz-clickable" id="galleryDropzone"
                      action="{{ route('media_save', ['id' => $item->id, 'entity' => 'rock', 'type' => 'gallery']) }}"
                      data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'rock', 'type' => 'gallery']) }}">
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
                </div>
              </div>
              <!-- ./Form add gallery img-->

              <!-- Form micro photos -->
              <div class="row">
                <div class="col">
                  <!-- Micro photos -->
                  <div class="row">
                    <div class="col-lg-6 form-group">
                      <label class=" col-form-label text-lg-right">Загрузка изображений микроскопа с
                        анализатором</label>

                      <!-- PplDropzone -->
                      <form class="dropzone dropzone-queue mb-2" id="microPplDropzone"
                        action="{{ route('media_save', ['id' => $item->id, 'entity' => 'rock', 'type' => 'ppl']) }}"
                        data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'rock', 'type' => 'ppl']) }}">
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
                        action="{{ route('media_save', ['id' => $item->id, 'entity' => 'rock', 'type' => 'xpl']) }}"
                        data-url="{{ route('media_get', ['id' => $item->id, 'entity' => 'rock', 'type' => 'xpl']) }}">
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
        <div class="col-12">
          <!-- Card -->
          <div class="card mt-3">
            {{Form::open([
                        'route' => ['rocks.update', $item->id],
                        'files' => true,
                        'method' => 'put',
                        'enctype' => 'multipart/form-data'
                        ])}}

            <div class="card-header">
              <h3>Изменение породы</h3>
              @include('admin.errors')
            </div>

            <!-- Card-body -->
            <div class="card-body">
              <div class="row row-cols-1 row-cols-lg-2">
                <div class="col">
                  <div class="form-group">
                    <label for="inputName">Название <span class="required-field">*</span></label>
                    <input type="text" class="form-control" id="inputName" placeholder="" name="name"
                      value="{{$item->name}}" required oninvalid="this.setCustomValidity('Обязательное поле')"
                      oninput="setCustomValidity('')">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="inputName">Описание</label>
                    <textarea type="text" class="editor ck-content" name="description" id="inputDescription"
                      value="{{$item->description}}"></textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label for="inputName">3D обзор</label>
                    <input type="text" class="form-control" placeholder="" name="model_3d" value="{{$item->model_3d}}"
                      oninput="setCustomValidity('')">
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Тип</label>
                    {{Form::select('rock_type_id',
                                        $rockTypes,
                                        $item->getDictionaryPropId('rockType'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Класс</label>
                    {{Form::select('rock_class_id',
                                        $rockClasses,
                                        $item->getDictionaryPropId('rockClass'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Отряд</label>
                    {{Form::select('rock_squad_id',
                                        $rockSquads,
                                        $item->getDictionaryPropId('rockSquad'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Семейство</label>
                    {{Form::select('rock_family_id',
                                        $rockFamilies,
                                        $item->getDictionaryPropId('rockFamily'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Вид</label>
                    {{Form::select('rock_kind_id',
                                        $rockKinds,
                                        $item->getDictionaryPropId('rockKind'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Текстура</label>
                    {{Form::select('rock_texture_id',
                                        $rockTextures,
                                        $item->getDictionaryPropId('rockTexture'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Структура</label>
                    {{Form::select('rock_structure_id',
                                        $rockStructures,
                                        $item->getDictionaryPropId('rockStructure'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Породообразующие минералы</label>
                    {{Form::select('forming_minerals[]',
                                        $minerals,
                                        $selectedFormMinerals,
                                        ['class' => 'form-control select2', 'multiple'=>'multiple',
                                        'data-placeholder'=>'Выберите минералы'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Вторичные минералы</label>
                    {{Form::select('second_minerals[]',
                                        $minerals,
                                        $selectedSecMinerals,
                                        ['class' => 'form-control select2', 'multiple'=>'multiple',
                                        'data-placeholder'=>'Выберите минералы'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Акцессорные минералы</label>
                    {{Form::select('accessory_minerals[]',
                                        $minerals,
                                        $selectedAcMinerals,
                                        ['class' => 'form-control select2', 'multiple'=>'multiple',
                                        'data-placeholder'=>'Выберите минералы'])
                                        }}
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label>Окаменелости</label>
                    {{Form::select('fossils[]',
                                        $fossils,
                                        $selectedFossils,
                                        ['class' => 'form-control select2', 'multiple'=>'multiple',
                                        'data-placeholder'=>'Выберите окаменелости'])
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
            <!-- ./ Card-body -->
            <!-- Card-footer -->
            <div class="card-footer">
              <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
              <button class="btn btn-warning pull-right">Изменить</button>
            </div>
            <!-- ./ Card-footer -->

            {!! Form::close() !!}
          </div>
          <!-- ./ Card -->

  </section>
  <!-- ./ Main content -->
</div>
@endsection
