<div class="min-h-screen bg-gray-50 dark:from-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Shopping Cart
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Review and manage your items</p>
        </div>

        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-700 dark:text-green-300">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-red-700 dark:text-red-300">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center border border-gray-200 dark:border-gray-700">
                <svg class="mx-auto h-20 w-20 text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Start shopping to add items to your cart</p>
                <a href="{{ route('products.index') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-3">
                    @foreach ($cartItems as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition border border-gray-200 dark:border-gray-700">
                            <div class="p-4">
                                <div class="flex items-start gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        <div class="h-20 w-20 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                            {{ $item->product->name }}
                                        </h3>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                            Stock: {{ $item->product->stock_quantity }}
                                        </div>
                                        <div class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
                                            ${{ number_format($item->product->price, 2) }}
                                        </div>
                                    </div>

                                    <!-- Quantity & Actions -->
                                    <div class="flex flex-col items-end space-y-2">
                                        <div class="flex items-center space-x-2" wire:loading.class="opacity-50" wire:target="updateQuantity">
                                            <button
                                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                wire:loading.attr="disabled"
                                                @if($item->quantity <= 1) disabled @endif
                                                class="w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <div class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded min-w-[50px] text-center">
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $item->quantity }}</span>
                                            </div>
                                            <button
                                                wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                wire:loading.attr="disabled"
                                                @if($item->quantity >= $item->product->stock_quantity) disabled @endif
                                                class="w-8 h-8 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded hover:bg-indigo-100 dark:hover:bg-indigo-900 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                                            ${{ number_format($item->product->price * $item->quantity, 2) }}
                                        </div>
                                        <button
                                            wire:click="removeItem({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 disabled:opacity-50">
                                            <span wire:loading.remove wire:target="removeItem({{ $item->id }})">Remove</span>
                                            <span wire:loading wire:target="removeItem({{ $item->id }})">Removing...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 sticky top-6">
                        <div class="p-4 bg-indigo-600 rounded-t-lg">
                            <h2 class="text-lg font-bold text-white">Order Summary</h2>
                        </div>

                        <div class="p-4 space-y-4">
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Items ({{ $cartItems->count() }})</span>
                                    <span class="font-semibold">${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Shipping</span>
                                    <span class="font-semibold text-green-600">FREE</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="font-semibold text-gray-900 dark:text-white">Total</span>
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                        ${{ number_format($total, 2) }}
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <a href="{{ route('checkout') }}" wire:navigate class="flex items-center justify-center w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-lg font-semibold transition">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Proceed to Checkout
                                    </a>
                                    <a href="{{ route('products.index') }}" wire:navigate class="flex items-center justify-center w-full bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-medium transition">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
