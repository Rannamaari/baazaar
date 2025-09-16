<x-app-layout>
    <x-slot name="title">Browse All Categories - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Explore all product categories at Baazaar Maldives. Find electronics, fashion, automotive parts, home essentials, gift cards and more. Quality products with fast delivery across all atolls.</x-slot>
    <x-slot name="header">
        <h2 class="font-bold text-lg sm:text-xl md:text-2xl text-slate-800 leading-tight">
            All Categories
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">

            <!-- Categories Grid - Mobile Optimized -->
            <div
                class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-2 sm:gap-3 md:gap-4 lg:gap-6">
                @forelse($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group bg-white rounded-lg sm:rounded-xl shadow-sm border border-slate-200 p-2 sm:p-3 md:p-4 lg:p-6 hover:shadow-lg hover:border-blue-300 transition-all duration-300 hover:scale-105">

                        <!-- Category Icon - Responsive Sizes -->
                        <div class="text-center mb-2 sm:mb-3 md:mb-4">
                            <div
                                class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-16 lg:h-16 mx-auto bg-gradient-to-r from-blue-50 to-purple-50 rounded-full flex items-center justify-center mb-1 sm:mb-2 group-hover:from-blue-100 group-hover:to-purple-100 transition-all duration-300">
                                @if($category->icon)
                                    <x-category-icon :icon="$category->icon" size="text-xs sm:text-sm md:text-lg lg:text-2xl" />
                                @else
                                    <x-heroicon-o-squares-2x2
                                        class="h-3 w-3 sm:h-4 sm:w-4 md:h-5 md:w-5 lg:h-8 lg:w-8 text-slate-400" />
                                @endif
                            </div>
                        </div>

                        <!-- Category Info - Responsive Text -->
                        <div class="text-center">
                            <h3
                                class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-slate-800 mb-1 sm:mb-2 group-hover:text-blue-600 transition-colors leading-tight">
                                {{ $category->name }}
                            </h3>

                            @if($category->description)
                                <p class="text-slate-600 text-xs sm:text-sm mb-2 sm:mb-3 line-clamp-2 hidden sm:block">
                                    {{ $category->description }}
                                </p>
                            @endif

                            <!-- Product Count - Responsive -->
                            <div class="text-xs text-slate-500 mb-1 sm:mb-2 lg:mb-3 hidden sm:block">
                                {{ $category->products()->where('is_active', true)->count() }} products
                            </div>

                            <!-- Featured Badge - Responsive -->
                            @if($category->is_featured)
                                <span
                                    class="hidden sm:inline-flex items-center px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <x-heroicon-o-star class="w-2 h-2 sm:w-3 sm:h-3 mr-1" />
                                    <span class="hidden md:inline">Featured</span>
                                </span>
                            @endif
                        </div>

                        <!-- Hover Arrow - Responsive -->
                        <div class="mt-2 sm:mt-3 md:mt-4 flex justify-center">
                            <x-heroicon-o-arrow-right
                                class="h-3 w-3 sm:h-4 sm:w-4 md:h-5 md:w-5 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300" />
                        </div>
                    </a>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-12">
                        <x-heroicon-o-squares-2x2 class="h-16 w-16 text-slate-300 mx-auto mb-4" />
                        <h3 class="text-lg font-medium text-slate-800 mb-2">No categories found</h3>
                        <p class="text-slate-500">Check back later for new categories.</p>
                    </div>
                @endforelse
            </div>

            <!-- Back to Home -->
            <div class="mt-6 sm:mt-8 lg:mt-12 text-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors text-sm sm:text-base">
                    <x-heroicon-o-arrow-left class="h-3 w-3 sm:h-4 sm:w-4 mr-1 sm:mr-2" />
                    <span class="hidden sm:inline">Back to Home</span>
                    <span class="sm:hidden">Back</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>