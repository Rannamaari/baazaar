<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pre-Order Request') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="flex justify-center items-center mb-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-slate-800">🛒 Request a Pre-Order</h1>
                </div>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed mb-6">
                    Can't find what you're looking for? Let us source it for you! We'll review your request and get back to you with pricing and availability.
                </p>
                <div class="flex justify-center">
                    <a href="{{ route('pre-orders.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-slate-600 hover:bg-slate-700 text-white font-medium rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <x-heroicon-o-eye class="h-5 w-5 mr-2" />
                        View My Pre-Orders
                    </a>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-3xl p-8 shadow-2xl border-2 border-slate-200">
                <form action="{{ route('pre-orders.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Product Name -->
                    <div>
                        <label for="product_name" class="block text-lg font-semibold text-slate-700 mb-3">
                            Product Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="product_name" 
                               name="product_name" 
                               value="{{ old('product_name') }}"
                               placeholder="e.g., iPhone 15 Pro Max, Sony WH-1000XM5 Headphones"
                               required
                               class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200">
                        @error('product_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-lg font-semibold text-slate-700 mb-3">
                            Brand <span class="text-slate-500 text-sm">(Optional)</span>
                        </label>
                        <input type="text" 
                               id="brand" 
                               name="brand" 
                               value="{{ old('brand') }}"
                               placeholder="e.g., Apple, Sony, Samsung"
                               class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200">
                        @error('brand')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product URL -->
                    <div>
                        <label for="product_url" class="block text-lg font-semibold text-slate-700 mb-3">
                            Product Link <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="product_url" 
                               name="product_url" 
                               value="{{ old('product_url') }}"
                               placeholder="amazon.com/product-link or www.example.com/product"
                               required
                               class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200">
                        <p class="mt-2 text-sm text-slate-500">
                            Just paste the product link from Amazon, official website, or any online store. You can include or skip "www" and "https://" - we'll handle it!
                        </p>
                        @error('product_url')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Details -->
                    <div>
                        <label for="additional_details" class="block text-lg font-semibold text-slate-700 mb-3">
                            Additional Details <span class="text-slate-500 text-sm">(Optional)</span>
                        </label>
                        <textarea id="additional_details" 
                                  name="additional_details" 
                                  rows="4"
                                  placeholder="Any specific requirements, preferred color, storage capacity, or other details that might help us find the exact product you need..."
                                  class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 resize-none">{{ old('additional_details') }}</textarea>
                        @error('additional_details')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6 border border-blue-200">
                        <h3 class="text-lg font-semibold text-slate-800 mb-3">📞 What happens next?</h3>
                        <ul class="space-y-2 text-slate-600">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                We'll review your request within 24 hours
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                Our team will research pricing and availability
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                We'll contact you via WhatsApp with details and pricing
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-2">•</span>
                                Once confirmed, we'll begin sourcing your item
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-105">
                            <svg class="w-6 h-6 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Submit Pre-Order Request
                        </button>
                        
                        <a href="{{ route('home') }}" 
                           class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-200 text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>