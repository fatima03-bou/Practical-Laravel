@extends('layouts.app')

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
              <span class="font-semibold text-gray-700 mr-2">{{ __('stock_available') }}:</span>
              @if($viewData['product']->quantity_store > 10)
                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ $viewData['product']->quantity_store }} {{ __('in_stock') }}
                </span>
              @elseif($viewData['product']->quantity_store > 0)
                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ __('only') }} {{ $viewData['product']->quantity_store }} {{ __('left') }}
                </span>
              @else
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">
                  {{ __('out_of_stock') }}
                </span>
              @endif
            </div>

            <h3 class="font-semibold text-gray-700 mb-2">{{ __('description') }}:</h3>
            <p class="text-gray-600">{{ $viewData['product']->getDescription() }}</p>
          </div>
        </div>

        <!-- Add to Cart -->
        <form method="POST" action="{{ route('cart.add', ['id'=> $viewData['product']->getId()]) }}">
          @csrf
          <div class="space-y-4">
            <div class="flex items-center">
              <label for="quantity" class="block text-sm font-medium text-gray-700 mr-4">
                {{ __('quantity') }}:
              </label>
              <div class="relative flex items-center max-w-[8rem]">
                <button type="button" id="decrement-button" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-l-lg p-2 h-10 focus:outline-none" 
                        {{ $viewData['product']->quantity_store == 0 ? 'disabled' : '' }} onclick="decrementQuantity()">
                  <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                  </svg>
                </button>
                <input type="number" id="quantity" name="quantity" min="1" max="{{ $viewData['product']->quantity_store }}" value="1" 
                       class="bg-gray-50 border-x-0 border-gray-300 h-10 text-center text-gray-900 text-sm focus:ring-primary-500 focus:border-primary-500 block w-full py-2.5" 
                       {{ $viewData['product']->quantity_store == 0 ? 'disabled' : '' }}>
                <button type="button" id="increment-button" class="bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-r-lg p-2 h-10 focus:outline-none" 
                        {{ $viewData['product']->quantity_store == 0 ? 'disabled' : '' }} onclick="incrementQuantity()">
                  <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                  </svg>
                </button>
              </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
              <button type="submit" 
                      class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                      {{ $viewData['product']->quantity_store == 0 ? 'disabled' : '' }}>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l.4-2m-3.4 0l-1.4-7H6l-1.4 7m12.8 0h2m-6 3h-4a2 2 0 00-2 2v2h8v-2a2 2 0 00-2-2z"/>
                </svg>
                {{ __('add_to_cart') }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function incrementQuantity() {
    const quantityInput = document.getElementById("quantity");
    let quantity = parseInt(quantityInput.value);
    if (quantity < {{ $viewData['product']->quantity_store }}) {
      quantityInput.value = quantity + 1;
    }
  }

  function decrementQuantity() {
    const quantityInput = document.getElementById("quantity");
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
      quantityInput.value = quantity - 1;
    }
  }
</script>
@endsection
