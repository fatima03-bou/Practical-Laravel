<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ session('direction', 'ltr') }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
    <title>@yield('title', 'Online Store')</title>

    <style>
        /* Root Variables */
        :root {
            --primary-color: #2d98da;
            --secondary-color: #f5f7fa;
            --dark-color: #212121;
            --light-color: #ffffff;
            --font-family: 'Roboto', sans-serif;
            --header-height: 80px;
            --footer-bg: #1e1e1e;
            --transition-speed: 0.3s;
        }

        /* General Styles */
        body {
            font-family: var(--font-family);
            font-size: 1rem;
            color: var(--dark-color);
            margin: 0;
            background-color: var(--secondary-color);
            line-height: 1.6;
        }

        h1, h2, h3 {
            font-weight: 500;
        }

        a {
            text-decoration: none;
        }

        /* Header */
        header {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 20px 30px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: var(--light-color);
            font-size: 1rem;
            padding: 10px 15px;
            transition: color var(--transition-speed), transform var(--transition-speed);
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--secondary-color);
            transform: scale(1.05);
        }

        /* Masthead */
        .masthead {
            background: linear-gradient(135deg, #2d98da, #00bcd4);
            color: var(--light-color);
            padding: 120px 20px;
            text-align: center;
            border-bottom: 2px solid var(--secondary-color);
            margin-top: 100px;
        }

        .masthead h2 {
            font-size: 3.5rem;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .masthead .welcome-message {
            font-size: 1.2rem;
            font-weight: 400;
            color: var(--light-color);
        }

        /* Content */
        .content {
            background-color: var(--light-color);
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 30px;
            transition: transform var(--transition-speed);
        }

        .content:hover {
            transform: translateY(-8px);
        }

        /* Footer */
        footer {
            background-color: var(--footer-bg);
            color: var(--light-color);
            padding: 20px 30px;
            text-align: center;
            font-size: 0.9rem;
            margin-top: 30px;
        }

        footer a {
            color: var(--primary-color);
            font-weight: 600;
        }

        footer a:hover {
            color: var(--light-color);
            text-decoration: underline;
        }

        /* Button */
        .btn-warning {
            background-color: #f39c12;
            color: var(--light-color);
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color var(--transition-speed), transform var(--transition-speed);
        }

        .btn-warning:hover {
            background-color: #e67e22;
            transform: scale(1.05);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
            }

            .masthead h2 {
                font-size: 2.5rem;
            }

            .content {
                padding: 30px;
            }

            footer {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('home.index') }}" class="navbar-brand">Online Store</a>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="navbar-nav">
                    @if (Auth::check() && Auth::user()->role == 'super_admin')
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning">SuperAdmin Panel</a>
                    @endif
                    <a class="nav-link active" href="{{ route('home.index') }}">Home</a>
                    <a class="nav-link active" href="{{ route('product.index') }}">Products</a>
                    <a class="nav-link active" href="{{ route('cart.index') }}">Cart</a>
                    <a class="nav-link active" href="{{ route('home.about') }}">About</a>
                    @guest
                        <a class="nav-link active" href="{{ route('login') }}">{{__('message.login')}}</a>
                        <a class="nav-link active" href="{{ route('register') }}">{{__('message.register')}}</a>
                    @else
                        <a class="nav-link active" href="{{ route('myaccount.orders') }}">My Orders</a>
                        <form id="logout" action="{{ route('logout') }}" method="POST" class="d-inline">
                            <a role="button" class="nav-link active"
                                onclick="document.getElementById('logout').submit();">{{__('message.logout')}}</a>
                            @csrf
                        </form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    <!-- Masthead -->
    <div class="masthead">
        <h2>@yield('subtitle', 'A Modern Online Store')</h2>
        <div class="welcome-message">Welcome to your Online Store! Explore and shop the best products.</div>
    </div>

    <!-- Main Content -->
    <div class="container content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <small>Copyright - <a href="https://twitter.com/danielgarax" target="_blank">Daniel Correa</a> - <b>Paola Vallejo</b></small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
