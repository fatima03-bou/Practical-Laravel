@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<!-- Admin Dashboard Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-700 text-white p-10 rounded-2xl shadow-2xl mb-8">
  <h1 class="text-5xl font-semibold mb-4">Welcome Back, {{ Auth::user()->name }}</h1>
  <p class="text-lg font-light opacity-85">Your admin dashboard is your command center. Manage your store with ease using the sections below.</p>
</div>

<!-- Dashboard Overview Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
  <!-- Products Card -->
  <div class="bg-gray-800 text-white shadow-2xl rounded-2xl p-8 border-2 border-transparent hover:border-purple-500 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-purple-700">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-gray-300">Products</h2>
      <i class="fas fa-box-open text-purple-500 text-4xl"></i>
    </div>
    <p class="text-gray-400 text-base leading-relaxed mb-4">Manage and update your product catalog efficiently. Keep your inventory fresh and relevant to your customers.</p>
    <a href="{{ route('admin.product.index') }}" class="inline-block text-purple-500 font-semibold hover:text-white hover:underline transition duration-300 ease-in-out">View Products</a>
  </div>

  <!-- Categories Card -->
  <div class="bg-gray-800 text-white shadow-2xl rounded-2xl p-8 border-2 border-transparent hover:border-indigo-400 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-indigo-700">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-gray-300">Categories</h2>
      <i class="fas fa-folder-open text-indigo-400 text-4xl"></i>
    </div>
    <p class="text-gray-400 text-base leading-relaxed mb-4">Organize your products into categories for better structure and easier navigation.</p>
    <a href="{{ route('admin.category.index') }}" class="inline-block text-indigo-400 font-semibold hover:text-white hover:underline transition duration-300 ease-in-out">Manage Categories</a>
  </div>

  <!-- Orders Card -->
  <div class="bg-gray-800 text-white shadow-2xl rounded-2xl p-8 border-2 border-transparent hover:border-yellow-500 transition-all duration-300 ease-in-out transform hover:scale-105 hover:bg-yellow-600">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-semibold text-gray-300">Orders</h2>
      <i class="fas fa-truck text-yellow-500 text-4xl"></i>
    </div>
    <p class="text-gray-400 text-base leading-relaxed mb-4">Track and manage customer orders effortlessly. Ensure timely delivery and customer satisfaction.</p>
    <a href="{{ url('admin/orders') }}" class="inline-block text-yellow-500 font-semibold hover:text-white hover:underline transition duration-300 ease-in-out">View Orders</a>
  </div>
</div>

<!-- Confirmation Script for Deletion -->
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this product?');
    }
</script>
@endsection
