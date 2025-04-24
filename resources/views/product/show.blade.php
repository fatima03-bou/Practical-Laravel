@extends('layouts.app')

@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])

@section('content')
<div class="max-w-7xl mx-auto">
  <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2">
      <!-- Product Image -->
      <div class="relative h-96 md:h-full">
        <img src="{{ asset('/storage/'.$viewData['product']->getImage()) }}" alt="{{ $viewData['product']->getName() }}"
             class="w-full h-full object-cover">
             
        @if($viewData['product']->isDiscountActive())
          <div class="absolute top-4 left-4 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-md">
            SALE
          </div>
        @endif
      </div>

      <!-- Product Details -->
      <div class="p-6 md:p-8 flex flex-col justify-between">
        <div>
          <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
              {{ $viewData['product']->getName() }}
            </h1>
            <button class="text-gray-400 hover:text-red-500 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
              </svg>
            </button>
          </div>

          <!-- Price -->
          <div class="mb-6">
            @if($viewData['product']->isDiscountActive())
              <div class="flex items-center">
                <span class="line-through text-gray-400 text-lg">
                  {{ $viewData['product']->getPrice() }} DH
                </span>
                <span class="text-red-600 font-bold text-2xl ml-2">
                  {{ number_format($viewData['product']->getDiscountedPrice(), 2) }} DH
                </span>
                <span class="ml-2 bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ round((1 - $viewData['product']->getDiscountedPrice() / $viewData['product']->getPrice()) * 100) }}% OFF
                </span>
              </div>
            @else
              <span class="text-gray-800 font-bold text-2xl">
                {{ $viewData['product']->getPrice() }} DH
              </span>
            @endif
          </div>

          <!-- Rating -->
          <div class="flex items-center mb-6">
            <div class="flex text-yellow-400">
              @for ($i = 1; $i <= 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              @endfor
            </div>
            <span class="text-gray-500 ml-2">(36 reviews)</span>
          </div>

          <!-- Stock and Description -->
          <div class="mb-6">
            <div class="flex items-center mb-2">
              <span class="font-semibold text-gray-700 mr-2">{{ __('messages.stock_available') }}:</span>
              @if($viewData['product']->quantity_store > 10)
                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ $viewData['product']->quantity_store }} {{ __('messages.in_stock') }}
                </span>
              @elseif($viewData['product']->quantity_store > 0)
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ __('messages.only') }} {{ $viewData['product']->quantity_store }} {{ __('messages.left') }}
                </span>
              @else
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ __('messages.out_of_stock') }}
                </span>
              @endif
            </div>

            <h3 class="font-semibold text-gray-700 mb-2">{{ __('messages.description') }}:</h3>
            <p class="text-gray-600">{{ $viewData['product']->getDescription() }}</p>
          </div>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="{{ route('cart.add', ['id'=> $viewData['product']->getId()]) }}">
          @csrf
          <div class="space-y-4">
            <div class="flex items-center">
              <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">
                {{ __('messages.quantity') }}:
              </label>
              <div class="relative flex items-center max-w-[8rem]">
                <button type="button" id="decrement-button" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l-lg p-2 h-10 focus:outline-none" {{ $viewData["product"]->quantity_store == 0 ? 'disabled' : '' }}>
                  <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                  </svg>
                </button>
                <input type="number" id="quantity" name="quantity" min="1" max="{{ $viewData['product']->quantity_store }}" value="1" 
                       class="bg-gray-50 border-x-0 border-gray-300 h-10 text-center text-gray-900 text-sm focus:ring-primary-500 focus:border-primary-500 block w-full py-2.5" 
                       {{ $viewData["product"]->quantity_store == 0 ? 'disabled' : '' }}>
                <button type="button" id="increment-button" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r-lg p-2 h-10 focus:outline-none" {{ $viewData["product"]->quantity_store == 0 ? 'disabled' : '' }}>
                  <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                  </svg>
                </button>
              </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
              <button type="submit" 
                      class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                      {{ $viewData["product"]->quantity_store == 0 ? 'disabled' : '' }}>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                {{ __('messages.add_to_cart') }}
              </button>
              
              <button type="button" class="sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                {{ __('messages.add_to_wishlist') ?? 'Add to Wishlist' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Product Details Tabs -->
  <div x-data="{ activeTab: 'description' }" class="bg-white shadow-md rounded-xl overflow-hidden mb-12">
    <div class="border-b border-gray-200">
      <nav class="flex -mb-px">
        <button @click="activeTab = 'description'" :class="{ 'border-primary-500 text-primary-600': activeTab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description' }" class="py-4 px-6 font-medium text-sm border-b-2 transition">
          {{ __('messages.description') ?? 'Description' }}
        </button>
        <button @click="activeTab = 'specifications'" :class="{ 'border-primary-500 text-primary-600': activeTab === 'specifications', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'specifications' }" class="py-4 px-6 font-medium text-sm border-b-2 transition">
          {{ __('messages.specifications') ?? 'Specifications' }}
        </button>
        <button @click="activeTab = 'reviews'" :class="{ 'border-primary-500 text-primary-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }" class="py-4 px-6 font-medium text-sm border-b-2 transition">
          {{ __('messages.reviews') ?? 'Reviews' }}
        </button>
      </nav>
    </div>
    
    <div class="p-6">
      <div x-show="activeTab === 'description'" class="prose max-w-none">
        <p>{{ $viewData['product']->getDescription() }}</p>
        <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
      
      <div x-show="activeTab === 'specifications'" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="border rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 font-medium">Product Details</div>
            <div class="divide-y">
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Brand</span>
                <span class="font-medium">Brand Name</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Model</span>
                <span class="font-medium">Model XYZ</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Weight</span>
                <span class="font-medium">0.5 kg</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Dimensions</span>
                <span class="font-medium">10 x 5 x 2 cm</span>
              </div>
            </div>
          </div>
          
          <div class="border rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-4 py-2 font-medium">Additional Information</div>
            <div class="divide-y">
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Warranty</span>
                <span class="font-medium">1 Year</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Return Policy</span>
                <span class="font-medium">30 Days</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Country of Origin</span>
                <span class="font-medium">Morocco</span>
              </div>
              <div class="px-4 py-3 flex justify-between">
                <span class="text-gray-600">Shipping</span>
                <span class="font-medium">Free Shipping</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div x-show="activeTab === 'reviews'" x-cloak>
        <div class="space-y-6">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold">Customer Reviews</h3>
            <button class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition">
              Write a Review
            </button>
          </div>
          
          <div class="border-b pb-6">
            <div class="flex items-center mb-2">
              <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                @endfor
              </div>
              <span class="ml-2 text-gray-600">John D. - 2 weeks ago</span>
            </div>
            <h4 class="font-medium mb-2">Great product, highly recommend!</h4>
            <p class="text-gray-600">This product exceeded my expectations. The quality is excellent and it works perfectly. Shipping was fast too!</p>
          </div>
          
          <div class="border-b pb-6">
            <div class="flex items-center mb-2">
              <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 4; $i++)
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                @endfor
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
              <span class="ml-2 text-gray-600">Sarah M. - 1 month ago</span>
            </div>
            <h4 class="font-medium mb-2">Good product but shipping took longer than expected</h4>
            <p class="text-gray-600">The product itself is great, but I had to wait longer than the estimated delivery time. Otherwise, I'm satisfied with my purchase.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Related Products -->
  <div class="mb-12">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('messages.related_products') ?? 'Related Products' }}</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @for ($i = 1; $i <= 4; $i++)
      <div class="bg-white rounded-xl shadow-md overflow-hidden transition transform hover:scale-105 hover:shadow-lg">
        <div class="relative">
          <img src="https://picsum.photos/500/300?random={{ $i + 10 }}" alt="Product Image" class="w-full h-48 object-cover">
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-gray-800 mb-1">Related Product {{ $i }}</h3>
          <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
              @for ($j = 1; $j <= 5; $j++)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              @endfor
            </div>
            <span class="text-xs text-gray-500 ml-1">(24 reviews)</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-primary-600 font-bold">$59.99</span>
            <button class="bg-primary-600 hover:bg-primary-700 text-white p-2 rounded-full transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      @endfor
    </div>
  </div>
</div>

<script>
  // Quantity increment/decrement
  document.addEventListener('DOMContentLoaded', function() {
    const decrementBtn = document.getElementById('decrement-button');
    const incrementBtn = document.getElementById('increment-button');
    const quantityInput = document.getElementById('quantity');
    const maxQuantity = {{ $viewData['product']->quantity_store }};
    
    decrementBtn.addEventListener('click', function() {
      const currentValue = parseInt(quantityInput.value);
      if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
      }
    });
    
    incrementBtn.addEventListener('click', function() {
      const currentValue = parseInt(quantityInput.value);
      if (currentValue < maxQuantity) {
        quantityInput.value = currentValue + 1;
      }
    });
    
    quantityInput.addEventListener('change', function() {
      const currentValue = parseInt(quantityInput.value);
      if (currentValue < 1) {
        quantityInput.value = 1;
      } else if (currentValue > maxQuantity) {
        quantityInput.value = maxQuantity;
      }
    });
  });
</script>
@endsection
