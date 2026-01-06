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

            <!-- Welcome Section -->
            <div class="bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
                    <div class="text-center max-w-3xl mx-auto">
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            Welcome to <span class="text-indigo-600 dark:text-indigo-400">TrustFactory</span>
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Discover quality products with seamless shopping experience
                        </p>
                    </div>
                </div>
            </div>

            <!-- Featured Products -->
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">
                        Featured Products
                    </h2>
                    <p class="text-base text-gray-600 dark:text-gray-400">
                        Check out our popular items
                    </p>
                </div>

                @livewire('featured-products')

                <div class="mt-16 text-center">
                    <a href="{{ route('products.index') }}" wire:navigate class="inline-flex items-center gap-2 px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                        View All Products
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white dark:bg-gray-800 border-y border-gray-200 dark:border-gray-700 py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
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
                        </div>

                        <div class="w-full md:w-1/3 px-4 mb-6 md:mb-0">
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
                        </div>

                        <div class="w-full md:w-1/3 px-4">
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
