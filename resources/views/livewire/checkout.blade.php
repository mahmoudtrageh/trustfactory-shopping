<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Checkout
            </h1>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Review and complete your order</p>
        </div>

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                    <div class="p-4 bg-indigo-600 rounded-t-lg">
                        <h2 class="text-lg font-bold text-white">Order Items</h2>
                    </div>

                    <div class="p-4 space-y-3">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center gap-4 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <div class="h-16 w-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        {{ $item->product->name }}
                                    </h3>
                                    <div class="flex gap-3 text-sm text-gray-600 dark:text-gray-400">
                                        <span>${{ number_format($item->product->price, 2) }}</span>
                                        <span>×</span>
                                        <span>{{ $item->quantity }}</span>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($item->product->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 sticky top-6">
                    <div class="p-4 bg-green-600 rounded-t-lg">
                        <h2 class="text-lg font-bold text-white">Payment</h2>
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
                                <span class="text-2xl font-bold text-green-600 dark:text-green-400">
                                    ${{ number_format($total, 2) }}
                                </span>
                            </div>

                            <button
                                wire:click="placeOrder"
                                wire:loading.attr="disabled"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="placeOrder">
                                    Place Order
                                </span>
                                <span wire:loading wire:target="placeOrder" class="flex items-center justify-center">
                                    <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>

                            <a href="{{ route('cart') }}" wire:navigate class="mt-2 w-full flex items-center justify-center bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg font-medium transition">
                                Back to Cart
                            </a>
                        </div>

                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700 text-center text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center justify-center mb-1">
                                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Secure & Encrypted
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
