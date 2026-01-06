<div>
    <div class="mb-6">
        <input
            type="text"
            wire:model.live="search"
            placehoslder="Search products..."
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
        >
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if ($product->image)
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @endif
                </div>

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>

                    @if ($product->description)
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($product->description, 60) }}</p>
                    @endif

                    <div class="flex items-center justify-between mb-3">
                        <span class="text-2xl font-bold text-indigo-600">${{ number_format($product->price, 2) }}</span>
                        <span class="text-sm {{ $product->isLowStock() ? 'text-orange-600' : 'text-gray-600' }}">
                            Stock: {{ $product->stock_quantity }}
                        </span>
                    </div>

                    @if ($product->isOutOfStock())
                        <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed">
                            Out of Stock
                        </button>
                    @else
                        <button
                            wire:click="addToCart({{ $product->id }})"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition-colors duration-200"
                        >
                            Add to Cart
                        </button>

                        @if ($product->isLowStock())
                            <p class="text-xs text-orange-600 mt-2 text-center">Only {{ $product->stock_quantity }} left!</p>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No products found.</p>
            </div>
        @endforelse
    </div>
</div>
