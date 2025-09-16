<x-app-layout>
    <x-slot name="title">{{ $product->name }} - {{ $product->category->name }} | Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Buy {{ $product->name }} at Baazaar Maldives. {{ $product->description ? Str::limit(strip_tags($product->description), 150) : 'Quality product with fast delivery to all atolls. Secure payment options including COD and bank transfer. Order now!' }}</x-slot>
    <x-slot name="header">
        <div class="text-center py-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <div class="inline-flex items-center space-x-2 text-sm">
                    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">Home</a>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('category.show', $product->category->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                        {{ $product->category->name }}
                    </a>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-slate-700 font-medium">{{ $product->name }}</span>
                </div>
            </nav>
            
            <!-- Product Header -->
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-4 tracking-tight">
                {{ $product->name }}
            </h1>
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 font-semibold text-sm">
                <x-category-icon :icon="$product->category->icon" size="w-4 h-4" class="mr-2" />
                {{ $product->category->name }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
                <!-- Product Images -->
                <div x-data="productGallery()" x-init="init()">
                    @if($product->images->count() > 0)
                        <!-- Main Image Display -->
                        <div class="mb-6">
                            <div class="h-[500px] bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
                                <img x-show="currentImage" 
                                     :src="currentImage" 
                                     :alt="$product->name"
                                     class="w-full h-full object-contain cursor-pointer hover:scale-105 transition-transform duration-200"
                                     @click="openProduct()">
                                <div x-show="!currentImage" class="h-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                    <span class="text-slate-500 text-lg font-medium">No Image Selected</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Gallery -->
                        <div class="flex gap-3 overflow-x-auto pb-2">
                            @foreach($product->images as $index => $image)
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $image->path) }}" 
                                         alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                         class="w-24 h-24 object-cover rounded-xl border-2 cursor-pointer hover:border-blue-500 transition-all duration-300 hover:scale-105 thumbnail {{ $index === 0 ? 'border-blue-500 shadow-lg' : 'border-slate-200' }}"
                                         @click="selectImage('{{ asset('storage/' . $image->path) }}', {{ $index }})">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Images - Clickable Placeholder -->
                        <div class="h-[500px] bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl border-2 border-dashed border-slate-300 flex items-center justify-center cursor-pointer hover:bg-slate-200 transition-colors duration-200"
                             @click="openProduct()">
                            <div class="text-center">
                                <div class="text-8xl mb-6 text-slate-400">📷</div>
                                <span class="text-slate-500 text-xl font-medium">No Images Available</span>
                                <p class="text-slate-400 text-sm mt-2">Click to view product details</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="space-y-8">
                    <!-- Price Section -->
                    <div class="bg-white rounded-2xl p-8 shadow-lg border border-slate-200">
                        <div class="mb-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <span class="text-4xl font-bold text-slate-800">MVR {{ number_format($product->price, 2) }}</span>
                                @if($product->compare_at_price)
                                    <span class="text-xl text-slate-500 line-through">
                                        MVR {{ number_format($product->compare_at_price, 2) }}
                                    </span>
                                @endif
                            </div>
                            @if($product->compare_at_price)
                                <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    Save MVR {{ number_format($product->compare_at_price - $product->price, 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        @if($product->stock > 0)
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <div class="flex items-center text-green-700 font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    In stock ({{ $product->stock }} available)
                                </div>
                            </div>
                        @else
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center text-red-700 font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Out of stock
                                </div>
                            </div>
                        @endif

                        <!-- Add to Cart Form -->
                        @if($product->stock > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="qty" class="block text-sm font-semibold text-slate-700 mb-3">Quantity</label>
                                    <select name="qty" id="qty" 
                                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-medium py-3 px-4 text-lg">
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold text-lg transition-all duration-300 hover:scale-105 shadow-lg flex items-center justify-center space-x-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-slate-400 text-white px-8 py-4 rounded-xl cursor-not-allowed font-bold text-lg">
                                Out of Stock
                            </button>
                        @endif
                    </div>

                    @if($product->description)
                        <div class="bg-white rounded-2xl p-8 shadow-lg border border-slate-200">
                            <h3 class="text-2xl font-bold text-slate-800 mb-6">Product Description</h3>
                            <div class="prose prose-lg text-slate-700 max-w-none">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mt-16">
                    <div class="text-center mb-12">
                        <h3 class="text-4xl font-bold text-slate-800 mb-4">🛍️ Related Products</h3>
                        <p class="text-lg text-slate-600">You might also like these products</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                        @foreach($relatedProducts as $related)
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 border border-slate-200 overflow-hidden">
                                <a href="{{ route('product.show', $related->slug) }}" class="block">
                                    @if($related->featured_image_url)
                                        <div class="h-48 overflow-hidden bg-gradient-to-br from-slate-50 to-slate-100">
                                            <img src="{{ $related->featured_image_url }}" 
                                                 alt="{{ $related->name }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-4xl mb-3 text-slate-400">📷</div>
                                                <span class="text-slate-500 text-sm font-medium">No Image</span>
                                            </div>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="p-6">
                                    <h4 class="font-bold text-lg mb-3 line-clamp-2 leading-tight">
                                        <a href="{{ route('product.show', $related->slug) }}" 
                                           class="text-slate-800 hover:text-blue-600 transition-colors duration-200">
                                            {{ $related->name }}
                                        </a>
                                    </h4>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-slate-800">MVR {{ number_format($related->price, 2) }}</span>
                                        <a href="{{ route('product.show', $related->slug) }}" 
                                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold text-sm transition-colors duration-200">
                                            View Details
                                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
function productGallery() {
    return {
        currentImage: '',
        currentIndex: 0,
        images: [],
        
        init() {
            // Set the first image as current
            @if($product->images->count() > 0)
                this.currentImage = '{{ asset('storage/' . $product->images->first()->path) }}';
                this.images = [
                    @foreach($product->images as $image)
                        '{{ asset('storage/' . $image->path) }}',
                    @endforeach
                ];
                console.log('Gallery initialized with', this.images.length, 'images');
                console.log('Current image:', this.currentImage);
            @endif
        },
        
        selectImage(imageSrc, index) {
            console.log('Selecting image:', imageSrc, 'at index:', index);
            this.currentImage = imageSrc;
            this.currentIndex = index;
            
            // Update thumbnail borders using Alpine.js reactive approach
            this.$nextTick(() => {
                const thumbnails = document.querySelectorAll('.thumbnail');
                thumbnails.forEach((thumb, i) => {
                    if (i === index) {
                        thumb.classList.add('border-blue-500');
                        thumb.classList.remove('border-slate-200');
                    } else {
                        thumb.classList.remove('border-blue-500');
                        thumb.classList.add('border-slate-200');
                    }
                });
            });
        },
        
        openProduct() {
            // This function can be used for additional product actions
            console.log('Product image clicked');
        }
    }
}
</script>