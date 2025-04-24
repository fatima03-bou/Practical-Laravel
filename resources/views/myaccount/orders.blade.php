@foreach($orders as $order)
    <h3>Order #{{ $order->id }}</h3>
    <p>Status: {{ $order->status }}</p>
    <p>Total: ${{ $order->calculated_total }}</p>  <!-- عرض المجموع المحسوب -->

    <ul class="list-group">
        @forelse($order->items as $item)
            <li class="list-group-item d-flex align-items-center">
                {{-- Image du produit --}}
                <a href="{{ route('product.show', ['id' => $item->product->id]) }}" class="me-3">
                    <img src="{{ asset('storage/images/' . $item->product->image) }}"
                         alt="{{ $item->product->name }}"
                         class="img-thumbnail"
                         style="width: 100px; height: 100px;">
                </a>

                {{-- Infos produit --}}
                <div>
                    <p class="mb-1">
                        <strong>Product:</strong>
                        <a href="{{ route('product.show', ['id' => $item->product->id]) }}">
                            {{ $item->product->name }}
                        </a>
                    </p>
                    <p class="mb-1"><strong>Quantity:</strong> {{ $item->quantity }}</p>
                    <p class="mb-1"><strong>Unit Price:</strong> ${{ $item->price }}</p>
                    <p class="mb-0 text-primary fw-bold">
                        Total: ${{ $item->quantity * $item->price }}
                    </p>
                </div>
            </li>
        @empty
            <li class="list-group-item">No products found in this order.</li>
        @endforelse
    </ul>
@endforeach
