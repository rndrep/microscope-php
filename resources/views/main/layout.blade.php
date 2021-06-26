<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="index, follow, noodp" />
    <meta name="googlebot" content="index, follow" />
    <meta name="description" content="Цифровая коллекция" />
    <meta name="keywords" content="цифровой микроскоп, микроскоп, порода, минералы, окаменелости " />

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- <title>Login</title> -->

    <!-- style.css -->
    <link rel="stylesheet" href="/main/css/style.css" />
</head>
<body>
<div class="page">
    <!-- header -->
    <header class="header">
        <div class="container">
            <div class="header__row row">
                <a href="#" class="header__logo"></a>

                <div class="nav">
                    <a class="nav__link active" href="/"><span class="nav-item__span">Главная</span></a>
                    <a class="nav__link" href="#">Изучение</a>
                    <a class="nav__link" href="#">О сайте</a>
                    @if(Auth::check())
                        <a class="nav__link" href="/logout">Выйти</a>
                    @else
                        <a class="nav__link" href="/login">Войти</a>
                    @endif
                </div>
            </div>
            <!-- /.row -->
        </div>
    </header>
    <!-- /.header -->
    <!-- content -->
    @yield('content')

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row footer__row">
                <div class="col-lg-12">
                    <div class="footer__text">Национальный исследовательский Томский политехнический университет</div>
                    <div class="footer__text">TPU © 2021</div>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- js files -->
<script
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"
></script>

<script src="/main/js/app.min.js"></script>
</body>
</html>
