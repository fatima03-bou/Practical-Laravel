@extends('layouts.admin')
@section('title', $viewData["title"])

@section('content')
<div class="bg-white shadow-md rounded-xl p-8 mb-6">
  <h1 class="text-2xl font-semibold text-gray-800 mb-4">Welcome, Admin</h1>
  <p class="text-gray-600">
    This is your admin dashboard. Use the sidebar to manage products, categories, orders, and view reports.
  </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-blue-100 p-4 rounded-lg shadow-sm">
    <h2 class="text-lg font-medium text-blue-800 mb-2">🛒 Products</h2>
    <p class="text-sm text-blue-700">Add, edit, and manage your store’s products here.</p>
  </div>
  <div class="bg-green-100 p-4 rounded-lg shadow-sm">
    <h2 class="text-lg font-medium text-green-800 mb-2">📂 Categories</h2>
    <p class="text-sm text-green-700">Organize products into logical groups.</p>
  </div>
  <div class="bg-yellow-100 p-4 rounded-lg shadow-sm">
    <h2 class="text-lg font-medium text-yellow-800 mb-2">📦 Orders</h2>
    <p class="text-sm text-yellow-700">View and manage customer orders.</p>
  </div>
</div>
@endsection
