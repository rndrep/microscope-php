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
                        {{Form::open([
                        'route' => ['rocks.update', $rock->id],
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

                            <div class="form-group">
                                <label for="inputPhoto">Картинка</label>
                                <img src="{{$rock->getPhoto()}}" alt="" class="row img-responsive" width="200">
                                <input type="file" id="inputPhoto" name="photo">
                                {{-- <label class="btn btn-primary">Выбрать файл<input type="file" id="inputPhoto"
                                        name="photo" style="display:none"></label>--}}
                                <p class="help-block">(jpg, jpeg, png, bmp, gif, svg или webp)</p>
                            </div>
                            <div class="form-group">
                                @include('admin.input-microscope')
                            </div>
                            <div class="form-group">
                                @include('admin.input-gallery')
                            </div>
                            <div class="row row-cols-1 row-cols-lg-2">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="inputName">Название <span class="required-field">*</span></label>
                                        <input type="text" class="form-control" id="inputName" placeholder=""
                                            name="name" value="{{$rock->name}}" required
                                            oninvalid="this.setCustomValidity('Обязательное поле')"
                                            oninput="setCustomValidity('')">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="inputName">Описание</label>
                                        <textarea type="text" class="editor ck-content" name="description"
                                            id="inputDescription" value="{{$rock->description}}"></textarea>

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Тип</label>
                                        {{Form::select('rock_type_id',
                                        $rockTypes,
                                        $rock->getDictionaryPropId('rockType'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Класс</label>
                                        {{Form::select('rock_class_id',
                                        $rockClasses,
                                        $rock->getDictionaryPropId('rockClass'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Отряд</label>
                                        {{Form::select('rock_squad_id',
                                        $rockSquads,
                                        $rock->getDictionaryPropId('rockSquad'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Семейство</label>
                                        {{Form::select('rock_family_id',
                                        $rockFamilies,
                                        $rock->getDictionaryPropId('rockFamily'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Вид</label>
                                        {{Form::select('rock_kind_id',
                                        $rockKinds,
                                        $rock->getDictionaryPropId('rockKind'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Текстура</label>
                                        {{Form::select('rock_texture_id',
                                        $rockTextures,
                                        $rock->getDictionaryPropId('rockTexture'),
                                        ['class' => 'form-control select2', 'placeholder'=>'-'])
                                        }}
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Структура</label>
                                        {{Form::select('rock_structure_id',
                                        $rockStructures,
                                        $rock->getDictionaryPropId('rockStructure'),
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

                            <!-- Checkbox -->
                            <div class="form-group">
                                <label>
                                    {{Form::checkbox('is_public', '1', $rock->isPublic(),
                                    ['class'=>'minimal'])}}
                                    {{-- <input type="checkbox" class="minimal" name="is_public"
                                        value="{{$rock->isPublic()}}">--}}
                                </label>
                                <label>
                                    Публичный
                                </label>
                            </div>
                            <!-- ./ Checkbox -->

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
