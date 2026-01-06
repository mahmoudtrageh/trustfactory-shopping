<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

                    @if (session()->has('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($cartItems->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <h3 class="mt-4 text-xl font-medium text-gray-900">Your cart is empty</h3>
                            <p class="mt-2 text-gray-500">Start adding products to your cart!</p>
                            <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                                Browse Products
                            </a>
                        </div>
                    @else
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
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                                        <div class="text-sm text-gray-500">
                                                            Stock: {{ $item->product->stock_quantity }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">${{ number_format($item->product->price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2" wire:loading.class="opacity-50" wire:target="updateQuantity">
                                                    <button
                                                        wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                        wire:loading.attr="disabled"
                                                        @if($item->quantity <= 1) disabled @endif
                                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                                        -
                                                    </button>
                                                    <span class="px-4 py-1 text-gray-900">{{ $item->quantity }}</span>
                                                    <button
                                                        wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                        wire:loading.attr="disabled"
                                                        @if($item->quantity >= $item->product->stock_quantity) disabled @endif
                                                        class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                                        +
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button
                                                    wire:click="removeItem({{ $item->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="removeItem({{ $item->id }})"
                                                    class="text-red-600 hover:text-red-800 font-medium disabled:opacity-50">
                                                    <span wire:loading.remove wire:target="removeItem({{ $item->id }})">Remove</span>
                                                    <span wire:loading wire:target="removeItem({{ $item->id }})">Removing...</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 border-t pt-6">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-xl font-semibold text-gray-900">Total:</span>
                                <span class="text-2xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Continue Shopping
                                </a>
                                <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-8 py-3 rounded hover:bg-blue-700 transition font-medium">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
