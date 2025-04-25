<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'primary': {
              50: '#f3f8ff',
              100: '#e1f1ff',
              200: '#bfe2ff',
              300: '#81c3ff',
              400: '#56a3e6',
              500: '#3f7fd2',
              600: '#3366a3',
              700: '#285084',
              800: '#1e3a64',
              900: '#12244a',
            },
            'noir': '#0a0a0a', // New noir black color
            'accent': '#f7a142', // Secondary accent color
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            serif: ['Georgia', 'serif'],
          },
        }
      }
    }
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Georgia&display=swap" rel="stylesheet">
  <title>@yield('title', 'Online Store') - Best Deals Online</title>
  <meta name="description" content="Shop the best products at unbeatable prices. Free shipping on orders over $50!">
  <style>
    [x-cloak] { display: none !important; }
  </style>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white text-white font-sans antialiased flex flex-col min-h-screen">

  <!-- Header with Noir Background -->
  <nav class="bg-noir text-white py-4 shadow-xl sticky top-0 z-50">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <a href="{{ route('home.index') }}" class="text-3xl font-semibold flex items-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9l7-7-7-7m0 14l7 7-7 7" />
        </svg>
        <span class="font-serif text-xl">Online Store</span>
      </a>
      
      <!-- Desktop Navigation -->
      <div class="hidden lg:flex items-center space-x-8 text-lg">
        <a href="{{ route('home.index') }}" class="hover:text-accent transition duration-300">Home</a>
        <a href="{{ route('product.index') }}" class="hover:text-accent transition duration-300">Products</a>
        <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 hover:text-accent transition duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
          <span>Cart</span>
          @if(session()->has('products') && count(session()->get('products')) > 0)
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
              {{ count(session()->get('products')) }}
            </span>
          @endif
        </a>
        <a href="{{ route('home.about') }}" class="hover:text-accent transition duration-300">About</a>

        @guest
          <a href="{{ route('login') }}" class="hover:text-accent transition duration-300">Login</a>
          <a href="{{ route('register') }}" class="bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-full transition duration-300">Register</a>
        @else
          <a href="{{ route('orders.index') }}" class="hover:text-accent transition duration-300">My Orders</a>
          <form id="logout" action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="hover:text-accent transition duration-300">Logout</button>
          </form>
        @endguest
      </div>

      <!-- Mobile Menu Button -->
      <button x-data @click="document.getElementById('mobile-menu').classList.toggle('hidden')" class="lg:hidden text-white">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="lg:hidden hidden bg-gradient-to-r from-primary-500 to-primary-600 p-6 shadow-lg rounded-lg">
    <a href="{{ route('home.index') }}" class="text-white py-3 block">Home</a>
    <a href="{{ route('product.index') }}" class="text-white py-3 block">Products</a>
    <a href="{{ route('cart.index') }}" class="text-white py-3 block">Cart</a>
    <a href="{{ route('home.about') }}" class="text-white py-3 block">About</a>
    @guest
      <a href="{{ route('login') }}" class="text-white py-3 block">Login</a>
      <a href="{{ route('register') }}" class="text-white py-3 block bg-primary-500 hover:bg-primary-600 rounded-full">Register</a>
    @else
      <a href="{{ route('orders.index') }}" class="text-white py-3 block">My Orders</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-white py-3 block w-full">Logout</button>
      </form>
    @endguest
  </div>

  <!-- Main Content -->
  <div class="container mx-auto px-4 py-8 flex-grow">
    @yield('content')
  </div>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-primary-500 to-primary-600 text-white py-10 mt-auto">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- About Us -->
      <div>
        <h4 class="text-lg font-semibold mb-4">About Us</h4>
        <p class="text-sm">We are dedicated to providing the best shopping experience with quality products at competitive prices.</p>
      </div>
  
      <!-- Quick Links -->
      <div>
        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="{{ route('home.index') }}" class="hover:text-accent transition">Home</a></li>
          <li><a href="{{ route('product.index') }}" class="hover:text-accent transition">Products</a></li>
          <li><a href="{{ route('home.about') }}" class="hover:text-accent transition">About Us</a></li>
          <li><a href="#" class="hover:text-accent transition">Contact</a></li>
        </ul>
      </div>

      <!-- Contact Us -->
      <div>
        <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
        <p class="text-sm">123 Shopping Street, Retail City, 10001</p>
        <p class="text-sm">support@onlinestore.com</p>
        <p class="text-sm">+1 (555) 123-4567</p>
      </div>
    </div>
  </footer>

</body>
</html>
