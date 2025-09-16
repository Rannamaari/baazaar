@php
    $allCategories = \App\Models\Category::where('is_active', true)->orderBy('name')->get();
@endphp

<nav x-data="{ open: false, searchOpen: false, categoriesOpen: false }"
    class="bg-white/95 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <!-- Desktop Layout (lg+) -->
        <div class="hidden lg:flex items-center h-16 justify-between gap-8">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">B</span>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Baazaar</span>
                </a>
            </div>

            <!-- Search Bar (Center) - Full Width -->
            <div class="flex items-center flex-1 max-w-4xl mx-12">
                <form action="{{ route('search.index') }}" method="GET" class="w-full"
                    onsubmit="return document.querySelector('input[name=search]').value.trim() !== ''">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search products, brands, categories…"
                            class="w-full pl-14 pr-6 py-3 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 text-slate-800 placeholder-slate-500 text-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-7 w-7 text-slate-500" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Shop by Category Button -->
            <div class="relative" x-data="{ categoryDropdownOpen: false }" @click.away="categoryDropdownOpen = false"
                @keydown.escape="categoryDropdownOpen = false">
                <button @click="categoryDropdownOpen = !categoryDropdownOpen"
                    class="flex items-center space-x-2 px-4 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition-all duration-200 font-semibold text-sm whitespace-nowrap"
                    x-bind:aria-expanded="categoryDropdownOpen" aria-controls="category-dropdown">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                    <span>Shop by Category</span>
                    <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform duration-200"
                        x-bind:class="categoryDropdownOpen ? 'rotate-180' : ''" />
                </button>

                <!-- Category Dropdown -->
                <div x-show="categoryDropdownOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    id="category-dropdown"
                    class="absolute top-full right-0 mt-3 w-[480px] bg-white rounded-2xl shadow-xl border border-slate-200 z-50 max-h-[420px] overflow-hidden"
                    style="display: none;">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800">Shop by Category</h3>
                        <p class="text-sm text-slate-600 mt-1">Discover products in {{ $allCategories->count() }} categories</p>
                    </div>
                    <div class="p-4 overflow-y-auto max-h-[320px] custom-scrollbar">
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($allCategories as $category)
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="group flex items-center px-4 py-3 text-sm text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 border border-transparent hover:border-blue-200"
                                    @click="categoryDropdownOpen = false">
                                    <div class="w-2 h-2 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full mr-3 opacity-60 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="truncate">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 rounded-b-2xl">
                        <a href="{{ route('categories.index') }}" 
                           class="text-blue-600 hover:text-blue-700 text-sm font-semibold inline-flex items-center group"
                           @click="categoryDropdownOpen = false">
                            View All Categories
                            <x-heroicon-o-arrow-right class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center space-x-4">
                <!-- Pre Order Button -->
                <a href="{{ route('pre-orders.create') }}"
                    class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-full text-sm font-semibold transition-all duration-200 hover:from-orange-600 hover:to-red-600 hover:shadow-lg transform hover:scale-105">
                    Pre Order
                </a>


                <!-- Greeting / Auth -->
                @auth
                    <span class="text-slate-700 text-sm font-medium px-2">Hi,
                        {{ explode(' ', Auth::user()->name)[0] }}!</span>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center px-4 py-2 text-sm font-medium text-slate-700 hover:text-blue-600 focus:outline-none transition-all duration-200 rounded-lg hover:bg-slate-50">
                                <x-heroicon-o-user-circle class="h-6 w-6" />
                                <x-heroicon-o-chevron-down class="ml-1 h-4 w-4" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')"
                                class="font-semibold text-blue-600 border-b border-slate-200 pb-2 mb-2">
                                <x-heroicon-o-chart-bar class="w-4 h-4 mr-2 inline" />
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('addresses.index')">
                                <x-heroicon-o-map-pin class="w-4 h-4 mr-2 inline" />
                                {{ __('My Addresses') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('pre-orders.index')">
                                <x-heroicon-o-shopping-bag class="w-4 h-4 mr-2 inline" />
                                {{ __('My Pre-Orders') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                <x-heroicon-o-user class="w-4 h-4 mr-2 inline" />
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700">
                                    <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-2 inline" />
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-2 text-sm">
                        <a href="{{ route('login') }}"
                            class="text-slate-600 hover:text-blue-600 px-3 py-2 font-medium transition-all duration-200">
                            Sign In
                        </a>
                        <span class="text-slate-400">or</span>
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-700 px-3 py-2 font-semibold transition-all duration-200">
                            Register
                        </a>
                    </div>
                @endauth

                <!-- Cart Icon with Badge -->
                <div class="relative">
                    <a href="{{ route('cart.index') }}"
                        class="p-3 text-slate-700 hover:text-blue-600 transition-all duration-200 hover:scale-105 group rounded-lg hover:bg-slate-50">
                        <x-heroicon-o-shopping-cart class="h-6 w-6" />
                        <x-cart-badge />
                    </a>
                </div>

                <!-- Wishlist (Heart) - Coming Soon -->
                <div class="relative group">
                    <button
                        class="p-3 text-slate-400 cursor-not-allowed rounded-lg hover:bg-slate-50 transition-all duration-200"
                        disabled>
                        <x-heroicon-o-heart class="h-6 w-6" />
                    </button>
                    <div
                        class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                        Coming Soon
                    </div>
                </div>
            </div>
        </div>

        <!-- Medium Screen Layout (md) -->
        <div class="hidden md:flex lg:hidden items-center h-16 justify-between gap-4">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div
                        class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">B</span>
                    </div>
                    <span
                        class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Baazaar</span>
                </a>
            </div>

            <!-- Search Bar (Reduced Width) -->
            <div class="flex items-center flex-1 max-w-md mx-4">
                <form action="{{ route('search.index') }}" method="GET" class="w-full"
                    onsubmit="return document.querySelector('input[name=search]').value.trim() !== ''">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products…"
                            class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 text-slate-800 placeholder-slate-500 text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 text-slate-500" />
                        </div>
                    </div>
                </form>
            </div>

            <!-- Shop by Category Button (Medium) -->
            <div class="relative" x-data="{ categoryDropdownOpen: false }" @click.away="categoryDropdownOpen = false"
                @keydown.escape="categoryDropdownOpen = false">
                <button @click="categoryDropdownOpen = !categoryDropdownOpen"
                    class="flex items-center space-x-1 px-3 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-200 font-semibold text-xs whitespace-nowrap"
                    x-bind:aria-expanded="categoryDropdownOpen" aria-controls="category-dropdown-md">
                    <x-heroicon-o-squares-2x2 class="h-4 w-4" />
                    <span>Categories</span>
                    <x-heroicon-o-chevron-down class="h-3 w-3 transition-transform duration-200"
                        x-bind:class="categoryDropdownOpen ? 'rotate-180' : ''" />
                </button>

                <!-- Category Dropdown (Medium) -->
                <div x-show="categoryDropdownOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    id="category-dropdown-md"
                    class="absolute top-full right-0 mt-3 w-[400px] bg-white rounded-2xl shadow-xl border border-slate-200 z-50 max-h-[380px] overflow-hidden"
                    style="display: none;">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-4 py-3 border-b border-slate-200">
                        <h3 class="text-base font-bold text-slate-800">All Categories</h3>
                        <p class="text-xs text-slate-600 mt-1">{{ $allCategories->count() }} categories available</p>
                    </div>
                    <div class="p-3 overflow-y-auto max-h-[280px] custom-scrollbar">
                        <div class="grid grid-cols-2 gap-1">
                            @foreach($allCategories as $category)
                                <a href="{{ route('category.show', $category->slug) }}"
                                    class="group flex items-center px-3 py-2 text-xs text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 border border-transparent hover:border-blue-200"
                                    @click="categoryDropdownOpen = false">
                                    <div class="w-1.5 h-1.5 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full mr-2 opacity-60 group-hover:opacity-100 transition-opacity"></div>
                                    <span class="truncate">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-2 border-t border-slate-200 rounded-b-2xl">
                        <a href="{{ route('categories.index') }}" 
                           class="text-blue-600 hover:text-blue-700 text-xs font-semibold inline-flex items-center group"
                           @click="categoryDropdownOpen = false">
                            View All
                            <x-heroicon-o-arrow-right class="ml-1 h-3 w-3 transition-transform group-hover:translate-x-0.5" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Compressed Actions -->
            <div class="flex items-center space-x-2">
                <!-- Pre Order Button (Smaller) -->
                <a href="{{ route('pre-orders.create') }}"
                    class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-3 py-2 rounded-full text-xs font-semibold transition-all duration-200 hover:from-orange-600 hover:to-red-600 hover:shadow-lg">
                    Pre Order
                </a>


                <!-- User Menu (Icon Only) -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center p-2 text-slate-700 hover:text-blue-600 focus:outline-none transition-all duration-200 rounded-lg hover:bg-slate-50"
                                title="User Menu">
                                <x-heroicon-o-user-circle class="h-5 w-5" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')"
                                class="font-semibold text-blue-600 border-b border-slate-200 pb-2 mb-2">
                                <x-heroicon-o-chart-bar class="w-4 h-4 mr-2 inline" />
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('addresses.index')">
                                <x-heroicon-o-map-pin class="w-4 h-4 mr-2 inline" />
                                {{ __('My Addresses') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('pre-orders.index')">
                                <x-heroicon-o-shopping-bag class="w-4 h-4 mr-2 inline" />
                                {{ __('My Pre-Orders') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                <x-heroicon-o-user class="w-4 h-4 mr-2 inline" />
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700">
                                    <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-2 inline" />
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-1 text-xs">
                        <a href="{{ route('login') }}"
                            class="text-slate-600 hover:text-blue-600 px-2 py-1 font-medium transition-all duration-200">
                            Sign In
                        </a>
                        <span class="text-slate-400">|</span>
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-700 px-2 py-1 font-semibold transition-all duration-200">
                            Register
                        </a>
                    </div>
                @endauth

                <!-- Cart Icon -->
                <div class="relative">
                    <a href="{{ route('cart.index') }}"
                        class="p-2 text-slate-700 hover:text-blue-600 transition-all duration-200 hover:scale-105 group rounded-lg hover:bg-slate-50"
                        title="Cart">
                        <x-heroicon-o-shopping-cart class="h-5 w-5" />
                        <x-cart-badge />
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Layout (sm) -->
        <div class="flex md:hidden items-center h-14 justify-between px-2">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div
                        class="w-7 h-7 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-sm">B</span>
                    </div>
                    <span
                        class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Baazaar</span>
                </a>
            </div>

            <!-- Right Actions (Minimal) -->
            <div class="flex items-center space-x-2">
                <!-- Category Button (Mobile) -->
                <div class="relative" x-data="{ categoryDropdownOpen: false }"
                    @click.away="categoryDropdownOpen = false" @keydown.escape="categoryDropdownOpen = false">
                    <button @click="categoryDropdownOpen = !categoryDropdownOpen"
                        class="p-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl"
                        title="All Categories" aria-label="All Categories" x-bind:aria-expanded="categoryDropdownOpen"
                        aria-controls="category-dropdown-mobile">
                        <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                    </button>

                    <!-- Category Dropdown (Mobile) -->
                    <div x-show="categoryDropdownOpen" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4"
                        id="category-dropdown-mobile"
                        class="fixed inset-x-4 top-20 bg-white rounded-2xl shadow-2xl border border-slate-200 z-50 max-h-[70vh] overflow-hidden"
                        style="display: none;">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold">All Categories</h3>
                                    <p class="text-blue-100 text-sm mt-1">{{ $allCategories->count() }} categories available</p>
                                </div>
                                <button @click="categoryDropdownOpen = false"
                                    class="p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-full transition-all duration-200">
                                    <x-heroicon-o-x-mark class="h-6 w-6" />
                                </button>
                            </div>
                        </div>
                        <div class="p-4 overflow-y-auto max-h-[calc(70vh-120px)] custom-scrollbar">
                            <div class="grid grid-cols-1 gap-2">
                                @foreach($allCategories as $category)
                                    <a href="{{ route('category.show', $category->slug) }}"
                                        class="group flex items-center px-4 py-4 text-sm text-slate-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 border border-transparent hover:border-blue-200 hover:shadow-sm"
                                        @click="categoryDropdownOpen = false">
                                        <div class="w-3 h-3 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full mr-4 opacity-60 group-hover:opacity-100 transition-opacity"></div>
                                        <span class="flex-1">{{ $category->name }}</span>
                                        <x-heroicon-o-chevron-right class="h-4 w-4 text-slate-400 group-hover:text-blue-500 transition-colors" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 rounded-b-2xl">
                            <a href="{{ route('categories.index') }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl text-center font-semibold inline-flex items-center justify-center group hover:from-blue-700 hover:to-purple-700 transition-all duration-200"
                               @click="categoryDropdownOpen = false">
                                View All Categories
                                <x-heroicon-o-arrow-right class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search Icon -->
                <button @click="searchOpen = !searchOpen"
                    class="p-2 text-slate-700 hover:text-blue-600 transition-all duration-200 rounded-lg hover:bg-slate-50"
                    title="Search">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                </button>

                <!-- Cart Icon -->
                <div class="relative">
                    <a href="{{ route('cart.index') }}"
                        class="p-2 text-slate-700 hover:text-blue-600 transition-all duration-200 rounded-lg hover:bg-slate-50"
                        title="Cart">
                        <x-heroicon-o-shopping-cart class="h-5 w-5" />
                        <x-cart-badge />
                    </a>
                </div>

                <!-- User Icon / Auth -->
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center p-2 text-slate-700 hover:text-blue-600 focus:outline-none transition-all duration-200 rounded-lg hover:bg-slate-50"
                                title="User Menu">
                                <x-heroicon-o-user-circle class="h-5 w-5" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')"
                                class="font-semibold text-blue-600 border-b border-slate-200 pb-2 mb-2">
                                <x-heroicon-o-chart-bar class="w-4 h-4 mr-2 inline" />
                                {{ __('Dashboard') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('addresses.index')">
                                <x-heroicon-o-map-pin class="w-4 h-4 mr-2 inline" />
                                {{ __('My Addresses') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('pre-orders.index')">
                                <x-heroicon-o-shopping-bag class="w-4 h-4 mr-2 inline" />
                                {{ __('My Pre-Orders') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                <x-heroicon-o-user class="w-4 h-4 mr-2 inline" />
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700">
                                    <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-2 inline" />
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                        class="p-2 text-slate-600 hover:text-blue-600 transition-all duration-200 rounded-lg hover:bg-slate-50"
                        title="Sign In">
                        <x-heroicon-o-user-circle class="h-5 w-5" />
                    </a>
                @endauth

                <!-- Hamburger Menu -->
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 transition-all duration-200">
                    <x-heroicon-o-bars-3 class="h-5 w-5" />
                </button>
            </div>
        </div>
    </div>



    <!-- Mobile Search Overlay -->
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 py-4">
        <form action="{{ route('search.index') }}" method="GET">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search products, brands, categories…"
                    class="w-full pl-12 pr-4 py-4 border border-slate-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 text-slate-800 placeholder-slate-500 text-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-7 w-7 text-slate-500" />
                </div>
            </div>
        </form>
    </div>


    <!-- Mobile Hamburger Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden bg-white/95 backdrop-blur-md border-t border-slate-200">
        <div class="pt-4 pb-3 space-y-3 px-4">
            <!-- Pre Order Button (Mobile) -->
            <a href="{{ route('pre-orders.create') }}"
                class="block bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-3 rounded-full text-center font-semibold transition-all duration-200">
                Pre Order
            </a>



            <!-- Cart Link (Mobile) -->
            <a href="{{ route('cart.index') }}"
                class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200 border-t border-slate-200 pt-3">
                <x-heroicon-o-shopping-cart class="w-4 h-4 mr-2 inline" />
                Cart
            </a>

            @auth
                <!-- User Links (Mobile) -->
                <div class="border-t border-slate-200 pt-3 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="block text-blue-600 hover:text-blue-700 font-semibold text-sm tracking-wide transition-all duration-200 border-b border-slate-200 pb-2 mb-2">
                        <x-heroicon-o-chart-bar class="w-4 h-4 mr-2 inline" />
                        Dashboard
                    </a>

                    <a href="{{ route('addresses.index') }}"
                        class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200">
                        <x-heroicon-o-map-pin class="w-4 h-4 mr-2 inline" />
                        My Addresses
                    </a>

                    <a href="{{ route('pre-orders.index') }}"
                        class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200">
                        <x-heroicon-o-shopping-bag class="w-4 h-4 mr-2 inline" />
                        My Pre-Orders
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200">
                        <x-heroicon-o-user class="w-4 h-4 mr-2 inline" />
                        Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block text-red-600 hover:text-red-700 font-semibold text-sm tracking-wide transition-all duration-200">
                            <x-heroicon-o-arrow-right-on-rectangle class="w-4 h-4 mr-2 inline" />
                            Log Out
                        </a>
                    </form>
                </div>
            @else
                <!-- Auth Links (Mobile) -->
                <div class="border-t border-slate-200 pt-3 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200">
                        <x-heroicon-o-user-circle class="w-4 h-4 mr-2 inline" />
                        Sign In
                    </a>

                    <a href="{{ route('register') }}"
                        class="block text-slate-700 hover:text-blue-600 font-semibold text-sm tracking-wide transition-all duration-200">
                        <x-heroicon-o-user-plus class="w-4 h-4 mr-2 inline" />
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>