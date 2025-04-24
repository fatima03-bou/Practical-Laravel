<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- رابط ملف CSS الخاص بك إن وجد -->
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

  <!-- رابط Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <title>@yield('title', 'Admin - Online Store')</title>
  <style>
    :root {
  --primary-color: #2d6a4f; /* Dark green shade */
  --primary-dark: #1d4d3d; /* Even darker green */
  --secondary-color: #1cc88a;
  --info-color: #36b9cc;
  --warning-color: #f6c23e;
  --danger-color: #e74a3b;
  --dark-color: #2d3748;
  --light-color: #f8f9fc;
  --sidebar-dark: #2c3e50;
  --sidebar-darker: #1e2a38;
}
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fc;
    }
    
    /* Sidebar Styling */
    .sidebar {
      background: linear-gradient(180deg, var(--primary-color) 0%, var(--sidebar-darker) 100%);
      width: 250px;
      min-height: 100vh;
      transition: all 0.3s;
    }
    
    .sidebar-brand {
      background: rgba(255, 255, 255, 0.05);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 1.5rem 1rem;
    }
    
    .sidebar-divider {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin: 1rem 0;
    }
    
    .sidebar-link {
      color: rgba(255, 255, 255, 0.6);
      border-left: 4px solid transparent;
      padding: 0.75rem 1rem !important;
      margin-bottom: 0.25rem;
      transition: all 0.3s;
      border-radius: 0 5px 5px 0;
    }
    
    .sidebar-link:hover, .sidebar-link.active {
      color: white !important;
      background-color: rgba(255, 255, 255, 0.1);
      border-left: 4px solid var(--primary-color);
    }
    
    .sidebar-link i {
      width: 24px;
      text-align: center;
      margin-right: 8px;
      font-size: 1rem;
    }
    
    /* Navbar Styling */
    .topbar {
      background-color: white;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      border-bottom: 1px solid #e3e6f0;
    }
    
    .topbar .dropdown-toggle::after {
      display: none;
    }
    
    .topbar-divider {
      width: 0;
      border-right: 1px solid #e3e6f0;
      height: 2rem;
      margin: auto 1rem;
    }
    
    /* Card Styling */
    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
      margin-bottom: 1.5rem;
    }
    
    .card-header {
      background-color: white;
      border-bottom: 1px solid #e3e6f0;
      padding: 1rem 1.25rem;
      display: flex;
      align-items: center;
    }
    
    .card-header-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 10px;
      margin-right: 15px;
      color: white;
    }
    
    .icon-primary {
      background-color: var(--primary-color);
    }
    
    .icon-success {
      background-color: var(--secondary-color);
    }
    
    .icon-info {
      background-color: var(--info-color);
    }
    
    .icon-warning {
      background-color: var(--warning-color);
    }
    
    /* Button Styling */
    .btn {
      border-radius: 0.35rem;
      padding: 0.375rem 1rem;
      font-weight: 500;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
      background-color: var(--primary-dark);
      border-color: var(--primary-dark);
    }
    
    .btn-success {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
    }
    
    .btn-info {
      background-color: var(--info-color);
      border-color: var(--info-color);
    }
    
    .btn-warning {
      background-color: var(--warning-color);
      border-color: var(--warning-color);
    }
    
    .btn-danger {
      background-color: var(--danger-color);
      border-color: var(--danger-color);
    }
    
    /* Table Styling */
    .table {
      color: #5a5c69;
    }
    
    .table thead th {
      background-color: #f8f9fc;
      border-top: none;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.8rem;
      letter-spacing: 0.05em;
    }
    
    .table-action {
      width: 1%;
      white-space: nowrap;
    }
    
    /* Form Styling */
    .form-control, .form-select {
      border-radius: 0.35rem;
      padding: 0.5rem 1rem;
      border: 1px solid #d1d3e2;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: #bac8f3;
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .form-label {
      font-weight: 500;
      color: #5a5c69;
    }
    
    /* Footer Styling */
    .footer {
      background-color: white;
      border-top: 1px solid #e3e6f0;
      padding: 1.5rem 0;
      color: #5a5c69;
    }
    
    /* Alert Styling */
    .alert {
      border-radius: 0.35rem;
      border: none;
    }
    
    .alert-success {
      color: #0f5132;
      background-color: #d1e7dd;
    }
    
    .alert-danger {
      color: #842029;
      background-color: #f8d7da;
    }
    
    /* Admin Content */
    .admin-content {
      min-height: calc(100vh - 56px - 80px); /* Navbar height and footer height */
    }
    
    /* Pagination */
    .pagination {
      margin-bottom: 0;
    }
    
    .page-link {
      color: var(--primary-color);
      border: 1px solid #e3e6f0;
    }
    
    .page-item.active .page-link {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar bg-primary">
      <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
          <i class="bi bi-shop text-white fs-2"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
          <span class="text-white fw-bold">Admin Panel</span>
        </div>
      </div>
      
      <hr class="sidebar-divider">
      
      <ul class="nav flex-column px-2">
        <li class="nav-item">
          <a href="{{ route('admin.home.index') }}" class="nav-link sidebar-link">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.product.index') }}" class="nav-link sidebar-link">
            <i class="bi bi-box-seam"></i>
            <span>Products</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ route('admin.categorie.index') }}" class="nav-link sidebar-link">
            <i class="bi bi-tags"></i>
            <span>Categories</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ url('admin/fournisseurs') }}" class="nav-link sidebar-link">
            <i class="bi bi-truck"></i>
            <span>Fournisseurs</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ url('admin/statistics') }}" class="nav-link sidebar-link">
            <i class="bi bi-graph-up"></i>
            <span>Statistics</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ url('admin/orders') }}" class="nav-link sidebar-link">
            <i class="bi bi-cart-check"></i>
            <span>Orders</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a href="{{ url('admin/discounts/create') }}" class="nav-link sidebar-link">
            <i class="bi bi-percent"></i>
            <span>Discounts</span>
          </a>
        </li>
      </ul>
      
      <hr class="sidebar-divider">
      
      <div class="px-3 mt-2">
        <a href="{{ route('home.index') }}" class="btn btn-light w-100 d-flex align-items-center justify-content-center">
          <i class="bi bi-house-door me-2"></i>
          <span>Back to Store</span>
        </a>
      </div>
    </nav>
    <!-- End Sidebar -->

    <!-- Main Content -->
    <div class="flex-fill">
      <!-- Navbar -->
      <nav class="navbar navbar-expand topbar mb-4 static-top">
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle me-3">
          <i class="bi bi-list"></i>
        </button>
        
        <div class="d-none d-sm-inline-block form-inline me-auto ml-md-3 my-md-0 mw-100">
          <h1 class="h5 mb-0 text-gray-800">@yield('title', 'Dashboard')</h1>
        </div>
        
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="d-none d-lg-inline text-gray-600 small me-2">Admin User</span>
              <img class="img-profile rounded-circle" src="{{ asset('/img/undraw_profile.svg') }}" width="32" height="32">
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2 text-gray-400"></i> Profile</a></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2 text-gray-400"></i> Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2 text-gray-400"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </nav>

      <!-- Content Area -->
      <div class="container-fluid admin-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @yield('content')
      </div>
      
      <!-- Footer -->
      
    </div>
    <!-- End Main Content -->
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
