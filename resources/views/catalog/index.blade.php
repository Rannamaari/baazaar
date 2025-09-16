<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-slate-50 to-blue-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2 tracking-tight">
                    Welcome to <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Baazaar</span>
                </h1>
            </div>

            <!-- Two-Column Layout -->
            <div class="grid lg:grid-cols-5 gap-6 h-80 lg:h-96">
                <!-- Left Promotional Card (2 columns) -->
                <div class="lg:col-span-2 h-full">
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl p-8 text-white h-full flex flex-col justify-center relative overflow-hidden">
                        <!-- Background decoration -->
                        <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-8 -left-8 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10">
                            <h2 class="text-2xl md:text-3xl font-bold mb-4 leading-tight">
                                Digital Gift Cards & Gaming Credits
                            </h2>
                            <p class="text-blue-100 mb-6 text-lg">
                                Instant delivery • Best prices • 24/7 support • Secure transactions
                            </p>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center space-x-2 text-blue-100">
                                    <x-heroicon-o-check-circle class="h-5 w-5" />
                                    <span>Amazon Cards</span>
                                </div>
                                <div class="flex items-center space-x-2 text-blue-100">
                                    <x-heroicon-o-check-circle class="h-5 w-5" />
                                    <span>Apple Cards</span>
                                </div>
                                <div class="flex items-center space-x-2 text-blue-100">
                                    <x-heroicon-o-check-circle class="h-5 w-5" />
                                    <span>Netflix Cards</span>
                                </div>
                            </div>
                            <a href="{{ route('category.show', 'gift-recharge-cards') }}" 
                               class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <span>Buy Now</span>
                                <x-heroicon-o-arrow-right class="h-5 w-5 ml-2" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Slider (3 columns) -->
                <div class="lg:col-span-3 h-full">
                    <div x-data="heroSlider()" x-init="init()" class="relative rounded-2xl overflow-hidden shadow-2xl h-full">
                        <!-- Slides Container -->
                        <div class="relative h-full">
                            <!-- Slide 1: New Arrivals -->
                            <div x-show="currentSlide === 0" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-full"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform translate-x-0"
                                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                                 class="absolute inset-0 bg-gradient-to-br from-green-500 to-blue-600 flex items-center">
                                <div class="w-full px-16 py-6">
                                    <div class="max-w-md">
                                        <span class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">✨ NEW ARRIVALS</span>
                                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                                            Latest Tech & Gadgets
                                        </h3>
                                        <p class="text-green-100 mb-6 text-lg">
                                            Discover the newest smartphones, laptops, and smart devices
                                        </p>
                                        <a href="{{ route('category.show', 'electronics') }}" 
                                           class="inline-flex items-center bg-white text-green-600 px-6 py-3 rounded-xl font-semibold hover:bg-green-50 transition-all duration-200 shadow-lg">
                                            <span>Explore Now</span>
                                            <x-heroicon-o-arrow-right class="h-5 w-5 ml-2" />
                                        </a>
                                    </div>
                                </div>
                                <!-- Decorative Elements -->
                                <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                            </div>

                            <!-- Slide 2: Fashion Sale -->
                            <div x-show="currentSlide === 1" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-full"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform translate-x-0"
                                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                                 class="absolute inset-0 bg-gradient-to-br from-pink-500 to-purple-600 flex items-center">
                                <div class="w-full px-16 py-6">
                                    <div class="max-w-md">
                                        <span class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">🔥 HOT DEALS</span>
                                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                                            Fashion & Style
                                        </h3>
                                        <p class="text-pink-100 mb-6 text-lg">
                                            Up to 70% off on trending clothing and accessories
                                        </p>
                                        <a href="{{ route('category.show', 'clothing-fashion') }}" 
                                           class="inline-flex items-center bg-white text-pink-600 px-6 py-3 rounded-xl font-semibold hover:bg-pink-50 transition-all duration-200 shadow-lg">
                                            <span>Shop Fashion</span>
                                            <x-heroicon-o-arrow-right class="h-5 w-5 ml-2" />
                                        </a>
                                    </div>
                                </div>
                                <!-- Decorative Elements -->
                                <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                            </div>

                            <!-- Slide 3: Home Essentials -->
                            <div x-show="currentSlide === 2" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-full"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform translate-x-0"
                                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                                 class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 flex items-center">
                                <div class="w-full px-16 py-6">
                                    <div class="max-w-md">
                                        <span class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">🏠 HOME & LIVING</span>
                                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                                            Home Essentials
                                        </h3>
                                        <p class="text-orange-100 mb-6 text-lg">
                                            Everything you need to make your house a home
                                        </p>
                                        <a href="{{ route('category.show', 'home-essentials') }}" 
                                           class="inline-flex items-center bg-white text-orange-600 px-6 py-3 rounded-xl font-semibold hover:bg-orange-50 transition-all duration-200 shadow-lg">
                                            <span>Browse Home</span>
                                            <x-heroicon-o-arrow-right class="h-5 w-5 ml-2" />
                                        </a>
                                    </div>
                                </div>
                                <!-- Decorative Elements -->
                                <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                            </div>

                            <!-- Slide 4: Made in Maldives -->
                            <div x-show="currentSlide === 3" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-full"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 x-transition:leave="transition ease-in duration-300"
                                 x-transition:leave-start="opacity-100 transform translate-x-0"
                                 x-transition:leave-end="opacity-0 transform -translate-x-full"
                                 class="absolute inset-0 bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center">
                                <div class="w-full px-16 py-6">
                                    <div class="max-w-md">
                                        <span class="inline-block bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium mb-4">🇲🇻 FEATURED</span>
                                        <h3 class="text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
                                            Made in Maldives
                                        </h3>
                                        <p class="text-teal-100 mb-6 text-lg">
                                            Support local businesses and discover authentic Maldivian products
                                        </p>
                                        <a href="{{ route('category.show', 'made-in-maldives') }}" 
                                           class="inline-flex items-center bg-white text-teal-600 px-6 py-3 rounded-xl font-semibold hover:bg-teal-50 transition-all duration-200 shadow-lg">
                                            <span>Shop Local</span>
                                            <x-heroicon-o-arrow-right class="h-5 w-5 ml-2" />
                                        </a>
                                    </div>
                                </div>
                                <!-- Decorative Elements -->
                                <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                                <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                            </div>
                        </div>

                        <!-- Navigation Arrows -->
                        <button @click="prevSlide()" 
                                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all duration-200 backdrop-blur-sm z-10 shadow-lg hover:bg-white/40">
                            <x-heroicon-o-chevron-left class="h-5 w-5" />
                        </button>
                        <button @click="nextSlide()" 
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-3 rounded-full transition-all duration-200 backdrop-blur-sm z-10 shadow-lg hover:bg-white/40">
                            <x-heroicon-o-chevron-right class="h-5 w-5" />
                        </button>

                        <!-- Dots Indicator -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button @click="goToSlide(index)" 
                                        :class="currentSlide === index ? 'bg-white' : 'bg-white/40'"
                                        class="w-3 h-3 rounded-full transition-all duration-200"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Featured Categories Sections -->
            @if($featuredCategories->count() > 0)
                @foreach($featuredCategories as $category)
                    @if(isset($categoryProducts[$category->id]) && $categoryProducts[$category->id]['products']->count() > 0)
                        <div class="mb-16">
                            <!-- Category Header -->
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    @if($category->icon)
                                        <x-category-icon :icon="$category->icon" size="text-2xl" />
                                    @else
                                        <x-heroicon-o-squares-2x2 class="h-6 w-6 text-slate-600" />
                                    @endif
                                    <h2 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $category->name }}</h2>
                                    @if($category->is_featured)
                                        <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                            ⭐ Featured
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('category.show', $category->slug) }}" 
                                   class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center space-x-1 transition-colors">
                                    <span>See All</span>
                                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                                </a>
                            </div>
                            
                            <!-- Products Horizontal Scroll -->
                            <div class="relative">
                                <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                                    @foreach($categoryProducts[$category->id]['products'] as $product)
                                        <div class="flex-shrink-0 w-64 bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-lg transition-all duration-300 hover:scale-105">
                                            <!-- Product Image -->
                                            <a href="{{ route('product.show', $product->slug) }}" class="block">
                                                @if($product->featured_image_url)
                                                    <div class="h-48 overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100 rounded-t-xl">
                                                        <img src="{{ $product->featured_image_url }}" 
                                                             alt="{{ $product->name }}"
                                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    </div>
                                                @else
                                                    <div class="h-48 bg-gradient-to-br from-slate-100 to-slate-200 rounded-t-xl flex items-center justify-center">
                                                        <x-heroicon-o-photo class="h-12 w-12 text-slate-400" />
                                                    </div>
                                                @endif
                                            </a>
                                            
                                            <!-- Product Info -->
                                            <div class="p-4">
                                                <h3 class="font-semibold text-slate-800 mb-2 line-clamp-2 text-sm">
                                                    <a href="{{ route('product.show', $product->slug) }}" class="hover:text-blue-600 transition-colors">
                                                        {{ $product->name }}
                                                    </a>
                                                </h3>
                                                
                                                @if($product->description)
                                                    <p class="text-slate-600 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                                                @endif
                                                
                                                <!-- Price and Add to Cart -->
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-lg font-bold text-slate-800">{{ $product->price }} {{ $product->currency }}</span>
                                                        @if($product->compare_price && $product->compare_price > $product->price)
                                                            <span class="text-sm text-slate-500 line-through">{{ $product->compare_price }} {{ $product->currency }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    <!-- Add to Cart Button -->
                                                    <button onclick="addToCart({{ $product->id }})" 
                                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center space-x-1">
                                                        <x-heroicon-o-plus class="h-4 w-4" />
                                                        <span>ADD</span>
                                                    </button>
                                                </div>
                                                
                                                <!-- Delivery Time -->
                                                <div class="mt-2 text-xs text-slate-500 flex items-center">
                                                    <x-heroicon-o-clock class="h-3 w-3 mr-1" />
                                                    <span>11 MINS</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Scroll Indicator -->
                                @if($categoryProducts[$category->id]['products']->count() > 4)
                                    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-2 border border-slate-200">
                                        <x-heroicon-o-chevron-right class="h-5 w-5 text-slate-600" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- View All Categories Section -->
            <div class="mb-20">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">🛍️ Explore Categories</h2>
                    <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed mb-8">
                        Discover our complete range of product categories and find exactly what you're looking for
                    </p>
                    
                    <!-- View Categories Button -->
                    <a href="{{ route('categories.index') }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-110">
                        <x-heroicon-o-squares-2x2 class="h-6 w-6 mr-3" />
                        <span>View All Categories</span>
                        <x-heroicon-o-arrow-right class="h-5 w-5 ml-3 transform group-hover:translate-x-2 transition-transform duration-300" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Slider Script -->
    <script>
        function heroSlider() {
            return {
                currentSlide: 0,
                slides: [
                    { id: 0, title: 'New Arrivals' },
                    { id: 1, title: 'Fashion Sale' },
                    { id: 2, title: 'Home Essentials' },
                    { id: 3, title: 'Made in Maldives' }
                ],
                autoplayInterval: null,
                isPaused: false,
                
                init() {
                    this.startAutoplay();
                    // Pause on hover
                    this.$el.addEventListener('mouseenter', () => this.pauseAutoplay());
                    this.$el.addEventListener('mouseleave', () => this.resumeAutoplay());
                },
                
                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                },
                
                prevSlide() {
                    this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
                },
                
                goToSlide(index) {
                    this.currentSlide = index;
                },
                
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        if (!this.isPaused) {
                            this.nextSlide();
                        }
                    }, 4000); // Change slide every 4 seconds
                },
                
                pauseAutoplay() {
                    this.isPaused = true;
                },
                
                resumeAutoplay() {
                    this.isPaused = false;
                }
            }
        }

        // Add to Cart Script
        function addToCart(productId) {
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 opacity-65';
                    notification.textContent = 'Added to cart!';
                    document.body.appendChild(notification);
                    
                    // Remove notification after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                    
                    // Update cart badge
                    if (data.cart_count) {
                        const badge = document.querySelector('.cart-badge');
                        if (badge) {
                            badge.textContent = data.cart_count;
                            badge.classList.add('animate-pulse');
                            setTimeout(() => badge.classList.remove('animate-pulse'), 1000);
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>