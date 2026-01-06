<div>
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-700 dark:text-green-300">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-red-700 dark:text-red-300">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition h-full flex flex-col">
                <div class="aspect-square bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-8">
                    <svg class="w-20 h-20 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        {{ $product->name }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 flex-1">
                        {{ $product->description }}
                    </p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($product->price, 2) }}
                        </span>

                        @if ($product->isOutOfStock())
                            <span class="px-3 py-1 text-xs font-medium text-red-700 bg-red-50 dark:bg-red-900/20 dark:text-red-400 rounded-full">
                                Out of Stock
                            </span>
                        @elseif ($product->isLowStock())
                            <span class="px-3 py-1 text-xs font-medium text-amber-700 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400 rounded-full">
                                {{ $product->stock_quantity }} left
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-medium text-green-700 bg-green-50 dark:bg-green-900/20 dark:text-green-400 rounded-full">
                                In Stock
                            </span>
                        @endif
                    </div>

                    @auth
                        @if($product->isOutOfStock())
                            <button disabled class="w-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-6 py-4 rounded-lg cursor-not-allowed flex items-center justify-center gap-2 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @else
                            <button
                                wire:click="addToCart({{ $product->id }})"
                                wire:loading.attr="disabled"
                                wire:target="addToCart({{ $product->id }})"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-lg transition disabled:opacity-50 flex items-center justify-center gap-2 font-medium"
                                title="Add to Cart">
                                <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-lg text-center transition flex items-center justify-center gap-2 font-medium" title="Login to Purchase">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <p class="text-gray-600 dark:text-gray-400">No products available</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
