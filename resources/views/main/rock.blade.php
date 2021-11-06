@extends('main.layout')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- rock-card -->
                <article class="rock-card">
                    <!-- rock-img -->
                    <div class="row rock-card__top justify-content-center">
                        <div class="rock-card__img col-sm-12 col-md-7">
                            <img src="{{$item->getPhoto()}}" alt="" />
                        </div>

                        <div class="col-12 col-sm-12 col-md-5">
                            <!-- <button>sdfs</button>
                            <button>sdfsd</button> -->
                        </div>
                    </div>
                    <!-- /. rock-img -->

                    <!-- rock-info -->
                    <div class="row rock-card__main">
                        <div class="rock-card__details order-sm-2 col-sm-5">
                            <h1>Детали</h1>
                            <ul class="card-list list-group list-group-flush">
                                <li class="list-group-item">
                                    Тип: <a class="card-list__link">{{$item->getDictionaryPropName('rockType')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Класс: <a class="card-list__link">{{$item->getDictionaryPropName('rockClass')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Отряд: <a class="card-list__link">{{$item->getDictionaryPropName('rockSquad')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Семейство: <a class="card-list__link">{{$item->getDictionaryPropName('rockFamily')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Вид: <a class="card-list__link">{{$item->getDictionaryPropName('rockKind')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Текстура: <a class="card-list__link">{{$item->getDictionaryPropName('rockTexture')}}</a>
                                </li>
                                <li class="list-group-item">
                                    Структура: <a class="card-list__link">{{$item->getDictionaryPropName('rockStructure')}}</a>
                                </li>
                                @include('main.rocks.minerals-section',
                                    ['name' => 'Породообразующие минералы',
                                    'items' => $item->getFormingMineralLinks()
                                    ]
                                )
                                @include('main.rocks.minerals-section',
                                    ['name' => 'Вторичные минералы',
                                    'items' => $item->getSecondMineralLinks()
                                    ]
                                )
                                @include('main.rocks.minerals-section',
                                    ['name' => 'Акцессорные минералы',
                                    'items' => $item->getAccessoryMineralLinks()
                                    ]
                                )
                            </ul>
                        </div>
                        <div class="rock-card__info order-sm-1 col-sm-7">
                            <h1>{{$item->name}}</h1>
                            <p class="rock-card__text">
                                {{$item->description}}
                            </p>
                        </div>
                    </div>
                    <!-- /. rock-info -->
                </article>
                <!-- /. rock-card -->
            </div>
        </div>
    </div>
</section>
@endsection
