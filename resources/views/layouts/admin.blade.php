<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Link to your CSS file, if any -->
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

  <!-- Link to Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <title>@yield('title', 'Admin - Online Store')</title>

  <style>
    :root {
      --primary-color: #212529; /* Dark background */
      --highlight-color: #007bff; /* Blue accents */
      --light-color: #f8f9fc;
      --dark-color: #343a40;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--primary-color);
      color: var(--light-color);
    }
    /* Navbar Styling */
    .navbar {
      background-color: var(--dark-color);
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .navbar-nav .nav-link {
      color: #f8f9fc;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: var(--highlight-color);
    }

    .navbar-brand {
      color: var(--light-color);
      font-weight: 600;
    }

    .navbar-toggler {
      background-color: var(--highlight-color);
    }

    .navbar-toggler-icon {
      background-image: none;
      color: var(--light-color);
    }

    /* Custom Styles for the Content */
    .admin-content {
      min-height: calc(100vh - 56px); /* Adjust for the height of the navbar */
    }

    /* Button Styling */
    .btn-primary {
      background-color: var(--highlight-color);
      border-color: var(--highlight-color);
    }

    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }

    .btn-light {
      background-color: #f8f9fc;
      border-color: #d1d3e2;
    }

    .btn-light:hover {
      background-color: #e2e6ea;
      border-color: #d1d3e2;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('admin.home.index') }}">Admin Panel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.home.index') }}">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.product.index') }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categorie.index') }}">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/fournisseurs') }}">Fournisseurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/statistics') }}">Statistics</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/orders') }}">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/discounts/create') }}">Discounts</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->

  <!-- Main Content -->
  <div class="container-fluid admin-content">
    @yield('content')
  </div>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
