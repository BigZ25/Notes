<html lang="pl">

<head>
    <title>Notatnik {{$title ?? null}}</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link href="{{URL::asset('style.css')}}" rel="stylesheet">
</head>

<body class="body">
<div class="wrapper">
    <div class="header">
        <h1><i class="far fa-clipboard"></i>Moje notatki</h1>
    </div>

    <div class="container">
        <div class="menu">
            <ul>
                @if (!Auth::guest())
                    <li><a href="/notes/">Moje Notatki</a></li>
                    <li><a href="/notes/create/">Nowa notatka</a></li>
                    <li><a href="/logout/">Wyloguj się</a></li>
                @endif
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth

                        @else
                            <li>
                                <a href="{{ route('login') }}">Zaloguj się</a>
                            </li>

                            @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}">Utwórz konto</a>
                                </li>
                            @endif

                        @endauth
                    </div>
                    @else
                @endif
            </ul>
        </div>

        <div class="page">
            @yield('content')
        </div>
    </div>

    <div class="footer">
        <p>© 2020 by Dominik Zięba.</p>
    </div>
</div>
</body>

</html>
