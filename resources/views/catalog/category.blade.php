<x-app-layout>
    <x-slot name="title">{{ $category->name }} - Shop {{ $category->name }} Products | Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Shop {{ $category->name }} products at Baazaar Maldives. {{ $category->description ?? 'Quality products with fast delivery to all atolls. Secure payments, competitive prices, and excellent customer service.' }} Browse our collection and order now!</x-slot>
    <div class="py-4">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6">
                <div class="p-4 sm:p-6">
                    <form method="GET" action="{{ route('category.show', $category->slug) }}">
                        <div class="flex gap-2 sm:gap-4">
                            <div class="flex-1 relative">
                                <input type="text" name="search" placeholder="Search in {{ $category->name }}..."
                                       value="{{ request('search') }}"
                                    class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-slate-700 font-medium placeholder-slate-400 py-3 px-4 text-base">
                                <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-slate-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 sm:px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold transition-all duration-300 hover:scale-105 shadow-lg flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <span class="hidden sm:inline">Search</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Navigation -->
            <div class="mb-6">
                <div class="flex flex-wrap gap-2 sm:gap-3 justify-center">
                    <a href="{{ route('categories.index') }}"
                        class="px-3 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 font-medium transition-all duration-200 hover:scale-105 shadow-sm text-sm">
                        All Categories
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" 
                            class="px-3 py-2 rounded-lg font-medium transition-all duration-200 hover:scale-105 shadow-sm text-sm {{ $cat->id === $category->id ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg' : 'bg-white text-slate-700 hover:bg-blue-50 border border-slate-200' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Filters (Hidden by default) -->
            <div id="mobile-filters" class="xl:hidden hidden mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Filters</h3>
                    
                    <!-- Subcategory Filter -->
                    @if($subcategories->count() > 0)
                        <div class="mb-4">
                            <h4 class="font-semibold text-slate-700 mb-2">Subcategories</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['subcategory' => null])) }}"
                                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ !request('subcategory') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }} text-center">
                                    All
                                </a>
                                @foreach($subcategories as $subcategory)
                                    <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['subcategory' => $subcategory->id])) }}"
                                       class="px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request('subcategory') == $subcategory->id ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }} text-center">
                                        {{ $subcategory->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Price Range Filter -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-slate-700 mb-2">Price Range</h4>
                        <form method="GET" action="{{ route('category.show', $category->slug) }}" class="space-y-2">
                            @foreach(request()->query() as $key => $value)
                                @if($key !== 'min_price' && $key !== 'max_price')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <div class="flex gap-2">
                                <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                                Apply Price Filter
                            </button>
                        </form>
                    </div>

                    <!-- Clear All Filters -->
                    @if(request()->hasAny(['search', 'subcategory', 'min_price', 'max_price', 'sort']))
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="w-full bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors duration-200 text-center block">
                            Clear All Filters
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filters and Products Section -->
            <div class="flex flex-col xl:flex-row gap-4 lg:gap-6">
                <!-- Left Sidebar - Filters -->
                <div class="xl:w-1/4 order-2 xl:order-1 hidden xl:block">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 lg:p-6 xl:sticky xl:top-4">
                        <h3 class="text-lg font-bold text-slate-800 mb-6">Filters</h3>

                        <!-- Subcategory Filter -->
                        @if($subcategories->count() > 0)
                            <div class="mb-6">
                                <h4 class="font-semibold text-slate-700 mb-3">Subcategories</h4>
                                <div class="space-y-2">
                                    <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['subcategory' => null])) }}"
                                        class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ !request('subcategory') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }}">
                                        All Subcategories
                                    </a>
                                    @foreach($subcategories as $subcategory)
                                        <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['subcategory' => $subcategory->id])) }}"
                                            class="block px-3 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ request('subcategory') == $subcategory->id ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-slate-100' }}">
                                            {{ $subcategory->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Price Range Filter -->
                        <div class="mb-6">
                            <h4 class="font-semibold text-slate-700 mb-3">Price Range</h4>
                            <form method="GET" action="{{ route('category.show', $category->slug) }}" class="space-y-3">
                                @foreach(request()->query() as $key => $value)
                                    @if($key !== 'min_price' && $key !== 'max_price')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <div class="flex gap-2">
                                    <input type="number" name="min_price" placeholder="Min"
                                        value="{{ request('min_price') }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                    <input type="number" name="max_price" placeholder="Max"
                                        value="{{ request('max_price') }}"
                                        class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200">
                                    Apply Price Filter
                                </button>
                            </form>
                        </div>

                        <!-- Clear All Filters -->
                        @if(request()->hasAny(['search', 'subcategory', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="w-full bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors duration-200 text-center block">
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Right Content - Products -->
                <div class="xl:w-3/4 order-1 xl:order-2">
                    <!-- Top Bar - Sort and View Toggle -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <!-- Mobile Filter Toggle -->
                        <div class="xl:hidden">
                            <button onclick="document.getElementById('mobile-filters').classList.toggle('hidden')" 
                                    class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                                </svg>
                                <span>Filters</span>
                            </button>
                        </div>
                        <!-- Sort Dropdown -->
                        <div class="flex items-center gap-3">
                            <label for="sort" class="text-sm font-medium text-slate-700">Sort by:</label>
                            <form method="GET" action="{{ route('category.show', $category->slug) }}" class="inline">
                                @foreach(request()->query() as $key => $value)
                                    @if($key !== 'sort')
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endif
                                @endforeach
                                <select name="sort" id="sort" onchange="this.form.submit()"
                                    class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest
                                    </option>
                                    <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name_a_z" {{ request('sort') == 'name_a_z' ? 'selected' : '' }}>Name: A
                                        to Z</option>
                                    <option value="name_z_a" {{ request('sort') == 'name_z_a' ? 'selected' : '' }}>Name: Z
                                        to A</option>
                                </select>
                            </form>
                        </div>

                        <!-- View Toggle -->
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-medium text-slate-700">View:</span>
                            <div class="flex bg-slate-100 rounded-lg p-1">
                                <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['view' => 'grid'])) }}"
                                    class="p-2 rounded-md transition-colors duration-200 {{ $viewMode === 'grid' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600 hover:text-slate-800' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                        </path>
                                    </svg>
                                </a>
                                <a href="{{ route('category.show', $category->slug) }}?{{ http_build_query(array_merge(request()->query(), ['view' => 'list'])) }}"
                                    class="p-2 rounded-md transition-colors duration-200 {{ $viewMode === 'list' ? 'bg-white text-blue-600 shadow-sm' : 'text-slate-600 hover:text-slate-800' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Products Display -->
                    @if($viewMode === 'grid')
                        <!-- Grid View -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 lg:gap-6">
                    @else
                            <!-- List View -->
                            <div class="space-y-4">
                        @endif
                @forelse($products as $product)
                                @if($viewMode === 'grid')
                                    <!-- Grid View Card -->
                                    <div class="group bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105 border border-slate-200 overflow-hidden">
                        <!-- Product Image -->
                        <a href="{{ route('product.show', $product->slug) }}" class="block">
                            @if($product->featured_image_url)
                                                <div class="aspect-square overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100">
                                                    <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                            @else
                                                <div class="aspect-square bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                    <div class="text-center">
                                                        <div class="text-2xl sm:text-3xl mb-2 text-slate-400">📷</div>
                                                        <span class="text-slate-500 text-xs font-medium">No Image</span>
                                    </div>
                                </div>
                            @endif
                        </a>
                        
                        <!-- Product Info -->
                                        <div class="p-3 sm:p-4">
                            <!-- Product Name -->
                                            <h3 class="font-semibold text-sm sm:text-base mb-2 line-clamp-2 leading-tight">
                                <a href="{{ route('product.show', $product->slug) }}" 
                                   class="text-slate-800 hover:text-blue-600 transition-colors duration-200">
                                    {{ $product->name }}
                                </a>
                            </h3>

                                            <!-- Subcategory -->
                                            @if($product->subcategory)
                                                <div class="text-xs text-slate-500 mb-2 truncate">{{ $product->subcategory->name }}</div>
                                            @endif
                            
                            <!-- Price -->
                                            <div class="mb-3">
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1">
                                                    <span class="text-lg sm:text-xl font-bold text-slate-800">MVR {{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_at_price)
                                                        <span class="text-xs text-slate-500 line-through">
                                                            MVR {{ number_format($product->compare_at_price, 2) }}
                                        </span>
                                    @endif
                                </div>
                                @if($product->compare_at_price)
                                                    <div class="text-xs text-green-600 font-semibold">
                                                        Save MVR {{ number_format($product->compare_at_price - $product->price, 2) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Add to Cart Button -->
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="qty" value="1">
                                <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-2 rounded-lg font-semibold text-xs sm:text-sm shadow-sm hover:shadow-md transition-all duration-300 hover:scale-105 flex items-center justify-center space-x-1">
                                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                                                        </path>
                                                    </svg>
                                                    <span class="hidden sm:inline">Add to Cart</span>
                                                    <span class="sm:hidden">Add</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <!-- List View Card -->
                                    <div
                                        class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-200 overflow-hidden">
                                        <div class="flex flex-col md:flex-row">
                                            <!-- Product Image -->
                                            <div class="md:w-1/3">
                                                <a href="{{ route('product.show', $product->slug) }}" class="block">
                                                    @if($product->featured_image_url)
                                                        <div
                                                            class="h-48 md:h-full overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100">
                                                            <img src="{{ $product->featured_image_url }}" alt="{{ $product->name }}"
                                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="h-48 md:h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                                            <div class="text-center">
                                                                <div class="text-4xl mb-3 text-slate-400">📷</div>
                                                                <span class="text-slate-500 text-sm font-medium">No Image</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>

                                            <!-- Product Info -->
                                            <div class="flex-1 p-6">
                                                <div class="flex flex-col h-full">
                                                    <!-- Product Name and Subcategory -->
                                                    <div class="mb-3">
                                                        <h3 class="font-bold text-xl mb-2 leading-tight">
                                                            <a href="{{ route('product.show', $product->slug) }}"
                                                                class="text-slate-800 hover:text-blue-600 transition-colors duration-200">
                                                                {{ $product->name }}
                                                            </a>
                                                        </h3>
                                                        @if($product->subcategory)
                                                            <div class="text-sm text-slate-500">{{ $product->subcategory->name }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Price -->
                                                    <div class="mb-4">
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-3xl font-bold text-slate-800">MVR
                                                                {{ number_format($product->price, 2) }}</span>
                                                            @if($product->compare_at_price)
                                                                <span class="text-lg text-slate-500 line-through">
                                                                    MVR {{ number_format($product->compare_at_price, 2) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($product->compare_at_price)
                                                            <div class="text-lg text-green-600 font-semibold mt-1">
                                                                Save MVR
                                                                {{ number_format($product->compare_at_price - $product->price, 2) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Add to Cart Button -->
                                                    <div class="mt-auto">
                                                        <form action="{{ route('cart.add', $product) }}" method="POST"
                                                            class="inline">
                                                            @csrf
                                                            <input type="hidden" name="qty" value="1">
                                                            <button type="submit"
                                                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center space-x-2">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01">
                                                                    </path>
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="bg-white rounded-2xl p-12 shadow-lg border border-slate-200">
                            <div class="text-6xl mb-6">🔍</div>
                                        @if(request('search') || request('subcategory') || request('min_price') || request('max_price'))
                                            <h3 class="text-2xl font-bold text-slate-800 mb-4">No Products Found</h3>
                                            <p class="text-slate-600 text-lg mb-8">
                            @if(request('search'))
                                                    No products found matching "{{ request('search') }}"
                                                @elseif(request('subcategory'))
                                                    No products found in this subcategory
                                                @elseif(request('min_price') || request('max_price'))
                                                    No products found in this price range
                                                @endif
                                                in {{ $category->name }}.
                                            </p>
                                <a href="{{ route('category.show', $category->slug) }}" 
                                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                    </path>
                                    </svg>
                                                Clear Filters
                                </a>
                            @else
                                <h3 class="text-2xl font-bold text-slate-800 mb-4">No Products Available</h3>
                                            <p class="text-slate-600 text-lg mb-8">No products found in this category yet. Check
                                                back soon
                                                for new arrivals!</p>
                                <a href="{{ route('home') }}" 
                                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                    </path>
                                    </svg>
                                    Back to Home
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-4">
                                    {{ $products->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
            </div>
        </div>

        @push('scripts')
            <script src="{{ asset('js/category-filters.js') }}"></script>
        @endpush
</x-app-layout>