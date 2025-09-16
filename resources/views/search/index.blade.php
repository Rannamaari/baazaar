<x-app-layout>
    <x-slot name="title">{{ $query ? "Search Results for '$query'" : 'Search Products' }} - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">{{ $query ? "Search results for '$query' at Baazaar Maldives. Find electronics, fashion, automotive parts, gift cards and more." : 'Search products at Baazaar Maldives. Find electronics, fashion, automotive parts, gift cards and more with fast delivery across all atolls.' }}</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('search.index') }}" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="q" value="{{ $query }}" placeholder="Search products..."
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                autocomplete="off">
                        </div>
                        <div class="w-48">
                            <select name="category"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ $categorySlug === $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Search Results -->
            @if($query)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ $totalResults }} result{{ $totalResults !== 1 ? 's' : '' }} found for
                                "<strong>{{ $query }}</strong>"
                            </p>
                        </div>

                        @if($results->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($results as $product)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
                                        @if($product->images->count() > 0)
                                            <img src="{{ Storage::url($product->images->first()->path) }}" alt="{{ $product->name }}"
                                                class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-gray-500 dark:text-gray-400">No Image</span>
                                            </div>
                                        @endif

                                        <div class="p-4">
                                            <h3 class="font-semibold text-lg mb-2 dark:text-white">
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                    class="hover:text-blue-600 dark:hover:text-blue-400">
                                                    {{ $product->name }}
                                                </a>
                                            </h3>

                                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                                {{ $product->category->name }}
                                            </p>

                                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                                                {{ Str::limit($product->description, 100) }}
                                            </p>

                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-bold text-lg dark:text-white">
                                                        ${{ number_format($product->price, 2) }}
                                                    </span>
                                                    @if($product->compare_at_price)
                                                        <span class="text-sm text-gray-500 line-through">
                                                            ${{ number_format($product->compare_at_price, 2) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                        Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $results->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400 text-lg">
                                    No products found matching your search criteria.
                                </p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">
                                    Try adjusting your search terms or browse our categories.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">
                            Enter a search term to find products.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>