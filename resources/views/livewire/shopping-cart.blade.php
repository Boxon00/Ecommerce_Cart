<div>
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

    @if ($cartItems->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Add some products to get started!</p>
            <a href="{{ route('products') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg">
                Browse Products
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($cartItems as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 flex-shrink-0 bg-gray-200 rounded">
                                            @if ($item->product->image)
                                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover rounded">
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    ${{ number_format($item->product->price, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                            class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center"
                                        >
                                            -
                                        </button>
                                        <span class="w-12 text-center">{{ $item->quantity }}</span>
                                        <button
                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                            class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded flex items-center justify-center"
                                            @if($item->quantity >= $item->product->stock_quantity) disabled @endif
                                        >
                                            +
                                        </button>
                                    </div>
                                    @if ($item->quantity >= $item->product->stock_quantity)
                                        <p class="text-xs text-orange-600 mt-1">Max stock reached</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    ${{ number_format($item->getSubtotal(), 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <button
                                        wire:click="removeItem({{ $item->id }})"
                                        wire:confirm="Are you sure you want to remove this item?"
                                        class="text-red-600 hover:text-red-800"
                                    >
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 px-6 py-4 border-t">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-700">Total:</span>
                    <span class="text-2xl font-bold text-indigo-600">${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('products') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg text-center">
                        Continue Shopping
                    </a>
                    <button
                        wire:click="checkout"
                        wire:confirm="Are you sure you want to place this order?"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg"
                    >
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
