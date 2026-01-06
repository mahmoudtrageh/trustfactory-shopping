<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Products</h2>

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

                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse ($products as $product)
                            <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                <div class="aspect-square bg-gray-200 rounded-md mb-4 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>

                                <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $product->description }}</p>
                                <p class="text-2xl font-bold text-gray-900 mb-2">${{ number_format($product->price, 2) }}</p>

                                <div class="mb-4">
                                    @if ($product->isOutOfStock())
                                        <span class="inline-block px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full">
                                            Out of Stock
                                        </span>
                                    @elseif ($product->isLowStock())
                                        <span class="inline-block px-3 py-1 text-sm font-semibold text-yellow-700 bg-yellow-100 rounded-full">
                                            Low Stock: {{ $product->stock_quantity }} left
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">
                                            In Stock: {{ $product->stock_quantity }}
                                        </span>
                                    @endif
                                </div>

                                <button
                                    wire:click="addToCart({{ $product->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="addToCart({{ $product->id }})"
                                    @if($product->isOutOfStock()) disabled @endif
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition relative">
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                        @if($product->isOutOfStock())
                                            Out of Stock
                                        @else
                                            Add to Cart
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})" class="flex items-center justify-center">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                No products available.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
