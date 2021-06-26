@extends('main.layout')

@section('content')
<section class="pt-5 pb-3 text-center container">
    <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
            <h1 class="fw-light">Изучите нашу коллекцию</h1>
            <p class="lead text-muted">Просматривайте образцы горных пород в нашей коллекции.</p>
        </div>
    </div>
</section>

<!-- header -->
<section class="cards">
    <div class="container">
        <div class="row">
            <h1 class="cards__title col-lg-12">Коллекция</h1>
        </div>
        <!-- cards__row -->
        <div class="cards__row row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            @foreach($items as $item)
            <div class="col">
                <div class="card">
                    <a class="card__img" href="{{route('info', $item->id)}}">
                        <img src="{{$item->getPhoto()}}" alt="" />
                    </a>

                    <div class="card__body">
                        <h2 class="card__title">{{$item->name}}</h2>
                        <div class="btn-group btn-container" role="group" aria-label="Basic outlined example">
{{--                            <button type="button" class="btn">Микроскоп</button>--}}
                            <a href="{{route('info', $item->id)}}" type="button" class="btn">Информация</a>
{{--                            <button type="button" class="btn">Поворот</button>--}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <!-- ./cards__row -->
    </div>
</section>
@endsection
