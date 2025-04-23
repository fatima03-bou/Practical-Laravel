<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <title>@yield('title', __('message.online_store'))</title>
    @if (session('direction') === 'rtl')
        <link rel="stylesheet" href="{{ asset('css/rtl.css') }}">
    @endif
</head>

<body>
    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary py-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">{{__('message.online_store')}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    @if (Auth::check() && Auth::user()->role == 'super_admin')
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning">
                                {{__('message.superadmin_panel')}}
                            </a>
                        </div>
                    @endif
                    <a class="nav-link active" href="{{ route('home.index') }}">{{__('message.home')}}</a>
                    <a class="nav-link active" href="{{ route('product.index') }}">{{__('message.products')}}</a>
                    <a class="nav-link active" href="{{ route('cart.index') }}">{{__('message.cart')}}</a>
                    <a class="nav-link active" href="{{ route('home.about') }}">{{__('message.about')}}</a>
                    <div class="vr bg-white mx-2 d-none d-lg-block"></div>
                    @guest
                        <a class="nav-link active" href="{{ route('login') }}">{{__('message.login')}}</a>
                        <a class="nav-link active" href="{{ route('register') }}">{{__('message.register')}}</a>
                    @else
                        <a class="nav-link active" href="{{ route('myaccount.orders') }}">{{__('message.my_orders')}}</a>
                        <form id="logout" action="{{ route('logout') }}" method="POST">
                            <a role="button" class="nav-link active"
                                onclick="document.getElementById('logout').submit();">{{__('message.logout')}}</a>
                            @csrf
                        </form>
                    @endguest
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('message.language') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('language.change', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'fr') }}">Français</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'ar') }}">العربية</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <header class="masthead bg-primary text-white text-center py-4">
        <div class="container d-flex align-items-center flex-column">
            <h2>@yield('subtitle', __('message.a_laravel_online_store'))</h2>
        </div>
    </header>
    <!-- header -->

    <div class="container my-4">
        @yield('content')
    </div>

    <!-- footer -->
    <div class="copyright py-4 text-center text-white">
        <div class="container">
            <small>
                 {{__('message.copyright')}} - <a class="text-reset fw-bold text-decoration-none" target="_blank"
                    href="https://twitter.com/danielgarax">
                    Daniel Correa
                </a> - <b>Paola Vallejo</b>
            </small>
        </div>
    </div>
    <!-- footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
