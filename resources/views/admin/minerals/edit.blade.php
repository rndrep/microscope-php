@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <!-- Card-dropzone -->
          <div class="card mt-3">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6 form-group">
                  <label class=" col-form-label text-lg-right">Загрузка изображений микроскопа с анализатором</label>
                  <!-- PplDropzone -->
                  <div class="dropzone dropzone-queue mb-2" id="microPplDropzone">
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

                          <span class="dropzone-delete" data-dz-remove><i class="fas fa-times"></i></span>
                        </div>
                        <!--end::Toolbar-->
                      </div>
                    </div>
                    <!-- ./Items -->

                  </div>
                  <!-- ./PplDropzone-->
                  <span class="form-text text-muted"> Максимальный размер файла 1MB, максимальное количество 36.</span>

                </div>
                <div class="col-lg-6 form-group">
                  <label class="col-form-label text-lg-right">Загрузка изображений микроскопа без анализатора</label>
                  <!-- XplDropzone -->
                  <div class="dropzone dropzone-queue mb-2" id="microXplDropzone">
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

                          <span class="dropzone-delete" data-dz-remove><i class="fas fa-times"></i></span>
                        </div>
                        <!--end::Toolbar-->
                      </div>
                    </div>
                    <!-- ./Items -->

                  </div>
                  <!-- ./XplDropzone-->
                  <span class="form-text text-muted"> Максимальный размер файла 1MB, максимальное количество 36.</span>
                </div>
              </div>
            </div>
          </div>


        </div>
        <!-- ./ Card-dropzone -->


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

                </div>
                <!-- ./ Micro-photos -->
              </div>
            </div>

            <div class="row row-cols-1 row-cols-lg-2">
              <!-- TODO: Где шаблон?? -->
              @foreach($fields as $field)
              {!! $field->getHtml() !!}
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
          <!-- Card-footer -->
          <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-default">Назад</a>
            <button class="btn btn-warning pull-right">Изменить</button>
          </div>
          <!-- ./ Card-footer -->
        </div>

        {!! Form::close() !!}
      </div>
      <!-- ./ Card -->

    </div>
  </section>
  <!-- ./ Main content -->
</div>
@endsection