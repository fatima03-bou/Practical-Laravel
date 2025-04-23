<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="{{ asset('/css/admin.css') }}" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>@yield('title', 'Admin - Online Store')</title>

    <style>
        /* Body Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fb;
            margin: 0;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #1e1f25;
            padding: 15px 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 600;
            color: #fff;
        }

        .navbar-nav .nav-item .nav-link {
            color: #ddd;
            font-size: 1.1rem;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-item .nav-link:hover,
        .navbar-nav .nav-item .nav-link.active {
            color: #fff;
            background-color: #007bff;
            border-radius: 8px;
            transform: scale(1.05);
        }

        .navbar-nav .nav-item .nav-link i {
            margin-right: 8px;
        }

        /* Admin Profile Dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .profile-dropdown:hover .profile-avatar {
            transform: scale(1.1);
        }

        .profile-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            min-width: 200px;
            z-index: 1000;
        }

        .profile-dropdown:hover .profile-dropdown-menu {
            display: block;
        }

        .profile-dropdown-menu a {
            display: block;
            padding: 8px 0;
            color: #333;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .profile-dropdown-menu a:hover {
            color: #007bff;
            transform: translateX(5px);
        }

        /* Main Content */
        .content {
            background-color: #fff;
            padding: 40px 60px;
            margin-top: 70px;
            border-radius: 10px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }

        .content header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .content header h1 {
            font-size: 3rem;
            color: #333;
            font-weight: 700;
        }

        /* Content Card */
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-custom .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }

        .card-custom .card-body {
            background-color: #f9f9f9;
            border-radius: 0 0 10px 10px;
        }

        .card-custom .card-body p {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.5;
        }

        .btn-back {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .footer a {
            color: #00aaff;
            text-decoration: none;
        }

        .footer a:hover {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="{{ route('admin.home.index') }}">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('admin.home.index') }}"
                        class="nav-link {{ request()->routeIs('admin.home.index') ? 'active' : '' }}">
                        <i class="bi bi-house-door"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                        <i class="bi bi-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.statistics.index') }}"
                        class="nav-link {{ request()->routeIs('admin.statistics.index') ? 'active' : '' }}">
                        <i class="bi bi-bar-chart"></i> Statistics
                    </a>
                </li>
                <li class="nav-item profile-dropdown">
                    <img class="profile-avatar" src="{{ asset('/img/undraw_profile.svg') }}" alt="Admin Profile">
                    <div class="profile-dropdown-menu">
                        <a href="#">My Profile</a>
                        <a href="#">Settings</a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"
                                style="border: none; background: none; padding: 8px 0;">
                                Logout
                            </button>
                        </form>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('messages.language') }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('language.change', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'fr') }}">Français</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.change', 'ar') }}">العربية</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        <header>
            <h1>{{ $viewData['title'] }}</h1>
            <div>
                <span class="profile-font">Admin</span>
                <img class="img-profile" src="{{ asset('/img/undraw_profile.svg') }}" alt="Admin Profile">
            </div>
        </header>

        <!-- Content Goes Here -->
        <div class="g-0">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <small>
            Copyright - <a href="https://twitter.com/danielgarax" target="_blank">Daniel Correa</a> - <b>Paola
                Vallejo</b>
        </small>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
