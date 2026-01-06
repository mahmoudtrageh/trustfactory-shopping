<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TrustFactory Shopping Cart</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen">
            <livewire:layout.navigation />

            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 text-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                    <div class="text-center">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6">
                            Welcome to TrustFactory
                        </h1>
                        <p class="mt-4 max-w-2xl mx-auto text-lg sm:text-xl text-indigo-100">
                            Shop quality products with real-time stock updates and seamless checkout
                        </p>
                        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                            <a href="{{ route('products.index') }}" wire:navigate class="inline-flex items-center justify-center px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Browse Products
                            </a>
                            @guest
                                <a href="{{ route('register') }}" wire:navigate class="inline-flex items-center justify-center px-8 py-3 bg-indigo-700 text-white font-semibold rounded-lg hover:bg-indigo-800 transition border-2 border-white/20">
                                    Get Started
                                </a>
                            @endguest
                        </div>

                        <!-- Stats -->
                        <div class="mt-12 grid grid-cols-3 gap-6 max-w-2xl mx-auto">
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ \App\Models\Product::count() }}+</div>
                                <div class="text-indigo-200 text-sm mt-1">Products</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">{{ \App\Models\Order::count() }}+</div>
                                <div class="text-indigo-200 text-sm mt-1">Orders</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold">100%</div>
                                <div class="text-indigo-200 text-sm mt-1">Secure</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="text-center mb-10">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                        Featured Products
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        Check out our popular items
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        $products = \App\Models\Product::take(8)->get();
                    @endphp

                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="aspect-square bg-gray-100 dark:bg-gray-700 flex items-center justify-center p-6">
                                <svg class="w-20 h-20 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                                    {{ $product->description }}
                                </p>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                        ${{ number_format($product->price, 2) }}
                                    </span>

                                    @if ($product->isOutOfStock())
                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-300 rounded">
                                            Out of Stock
                                        </span>
                                    @elseif ($product->isLowStock())
                                        <span class="px-2 py-1 text-xs font-semibold text-amber-700 bg-amber-100 dark:bg-amber-900 dark:text-amber-300 rounded">
                                            {{ $product->stock_quantity }} left
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 dark:bg-green-900 dark:text-green-300 rounded">
                                            In Stock
                                        </span>
                                    @endif
                                </div>

                                @auth
                                    @if($product->isOutOfStock())
                                        <button disabled class="w-full bg-gray-300 dark:bg-gray-700 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed">
                                            Unavailable
                                        </button>
                                    @else
                                        <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition">
                                            Add to Cart
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" wire:navigate class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-center transition">
                                        Login to Purchase
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('products.index') }}" wire:navigate class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                        View All Products
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700 py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="flex justify-center mb-3">
                                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Real-Time Stock</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Live stock updates for all products</p>
                        </div>

                        <div class="text-center">
                            <div class="flex justify-center mb-3">
                                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Easy Checkout</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Seamless cart to order experience</p>
                        </div>

                        <div class="text-center">
                            <div class="flex justify-center mb-3">
                                <div class="bg-indigo-100 dark:bg-indigo-900 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Secure & Reliable</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Safe and protected transactions</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-gray-50 dark:bg-gray-900 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-gray-600 dark:text-gray-400 text-sm">
                        &copy; {{ date('Y') }} TrustFactory. Built with Laravel {{ Illuminate\Foundation\Application::VERSION }}
                    </p>
                </div>
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
