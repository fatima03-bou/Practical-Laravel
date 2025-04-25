@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<!-- Hero Section with Introduction -->
<section class="bg-gray-800 text-white py-16">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold mb-4">{{ __('Welcome to Our Store') }}</h2>
        <p class="text-xl mb-8">{{ __('Explore the best deals and products tailored to your needs.') }}</p>
        <a href="#product-list" class="bg-primary-500 text-white px-6 py-3 rounded-full hover:bg-primary-600 transition">
            {{ __('Shop Now') }}
        </a>
    </div>
</section>

<!-- Product Filter Section -->
<div class="bg-white p-6 rounded-lg mb-8 shadow-md">
    <form method="GET" action="{{ route('product.index') }}" class="flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <label for="on_sale" class="text-gray-800 font-semibold">{{ __('filter_products') }}</label>
            <select name="on_sale" onchange="this.form.submit()" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-primary-500 bg-white text-gray-800">
                <option value="">{{ __('all_products') }}</option>
                <option value="1" {{ request('on_sale') == '1' ? 'selected' : '' }}>{{ __('discounted_products') }}</option>
            </select>
        </div>
        <div class="flex items-center space-x-6">
            <label for="category_id" class="text-lg font-semibold">{{ __('category') }}</label>
            <select name="category_id" onchange="this.form.submit()" class="px-4 py-2 rounded-md border border-gray-300 focus:ring-2 focus:ring-primary-500 bg-white text-gray-800">
                <option value="">{{ __('all_categories') }}</option>
                @foreach ($viewData['categories'] as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<!-- Product List Section -->
<div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @foreach ($viewData["products"] as $product)
    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden border border-gray-200 transform hover:scale-105">
        <!-- Product Image -->
        <img src="https://picsum.photos/500/300?random={{ $product->id }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-lg transition-all duration-300 transform hover:scale-110">

        <!-- Product Info -->
        <div class="p-6 text-center">
            <a href="{{ route('product.show', ['id'=> $product->id]) }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition-colors block mb-4">
                {{ $product->name }}
            </a>

            <!-- Price -->
            <div class="mt-2">
                @if($product->isDiscountActive())
                <div class="flex justify-center items-center gap-2">
                    <span class="line-through text-gray-400 text-sm">{{ $product->price }} DH</span>
                    <span class="text-green-600 font-bold text-lg bg-green-100 px-2 py-1 rounded-md">
                        {{ $product->getFormattedDiscountedPrice() }} DH
                    </span>
                </div>
                @else
                <span class="text-gray-800 font-semibold text-lg">{{ $product->price }} DH</span>
                @endif
            </div>
        </div>

        <!-- Out of Stock Badge -->
        @if($product->quantity_store == 0)
        <span class="absolute top-3 right-3 bg-red-600 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">{{ __('out_of_stock') }}</span>
        @endif
    </div>
    @endforeach
</div>

<!-- Pagination Section -->
<div class="mt-8 flex justify-center">
    <nav class="inline-flex rounded-md shadow">
        {{ $viewData["products"]->links('pagination::tailwind') }}
    </nav>
</div>

@endsection
