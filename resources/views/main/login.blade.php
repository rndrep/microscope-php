@extends('main.layout')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="container container--xs">
                <div class="row justify-content-center">
                    <div class="col-12 col-xs-8 col-md-6 col-lg-4">
                        <div class="login">
                            <div class="card__body">
                                <h1 class="mb-1 text-center">Вход</h1>

                                <p class="fs-14 text-gray text-center mb-4">Пожалуйста, введите ваш логин и пароль.</p>
                                @include('admin.errors')
                                {{Form::open(['route' => 'auth.login'])}}
                                    <div class="mb-3">
                                        <label for="InputLogin" class="form-label">Логин</label>
                                        <input
                                            type="text"
                                            name="login"
                                            class="form-control"
                                            id="InputLogin"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="InputPassword" class="form-label">Пароль</label>
                                        <input
                                            type="text"
                                            name="password"
                                            type="password"
                                            class="form-control"
                                            id="InputPassword" />
                                    </div>

                                    <div class="btn-container">
                                        <button type="submit" class="btn">Log in →</button>
                                    </div>
                                {{Form::close()}}
                                <div class="btn-container">
                                <a href="{{route('login_tpu')}}" class="btn">Войти через ТПУ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
