<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pre-Order Details') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Pre-Order #{{ $preOrder->id }}</h1>
                    <p class="text-slate-600 mt-2">Requested on {{ $preOrder->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <a href="{{ route('pre-orders.index') }}" 
                   class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-medium transition-colors">
                    ← Back to Pre-Orders
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Product Information -->
                    <div class="bg-white rounded-3xl p-6 shadow-lg">
                        <h2 class="text-xl font-bold text-slate-800 mb-4">Product Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Product Name</label>
                                <p class="text-lg text-slate-900">{{ $preOrder->product_name }}</p>
                            </div>

                            @if($preOrder->brand)
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Brand</label>
                                    <p class="text-lg text-slate-900">{{ $preOrder->brand }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Product Link</label>
                                <a href="{{ $preOrder->product_url }}" 
                                   target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 font-medium break-all">
                                    {{ $preOrder->product_url }}
                                    <svg class="w-4 h-4 ml-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>

                            @if($preOrder->additional_details)
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Additional Details</label>
                                    <p class="text-slate-900 bg-slate-50 rounded-lg p-4">{{ $preOrder->additional_details }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Updates -->
                    @if($preOrder->admin_notes)
                        <div class="bg-blue-50 border border-blue-200 rounded-3xl p-6">
                            <h2 class="text-xl font-bold text-blue-900 mb-4">
                                <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Update from Our Team
                            </h2>
                            <p class="text-blue-900">{{ $preOrder->admin_notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-3xl p-6 shadow-lg">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Status</h3>
                        <div class="text-center">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium
                                {{ $preOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $preOrder->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $preOrder->status === 'sourcing' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $preOrder->status === 'sourced' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $preOrder->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $preOrder->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $preOrder->status_label }}
                            </span>
                        </div>

                        <!-- Status Timeline -->
                        <div class="mt-6 space-y-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-3"></div>
                                <span class="text-sm text-slate-600">Request submitted</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ in_array($preOrder->status, ['reviewing', 'sourcing', 'sourced', 'completed']) ? 'bg-green-500' : 'bg-slate-300' }} mr-3"></div>
                                <span class="text-sm {{ in_array($preOrder->status, ['reviewing', 'sourcing', 'sourced', 'completed']) ? 'text-slate-900' : 'text-slate-400' }}">Under review</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ in_array($preOrder->status, ['sourcing', 'sourced', 'completed']) ? 'bg-green-500' : 'bg-slate-300' }} mr-3"></div>
                                <span class="text-sm {{ in_array($preOrder->status, ['sourcing', 'sourced', 'completed']) ? 'text-slate-900' : 'text-slate-400' }}">Being sourced</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ in_array($preOrder->status, ['sourced', 'completed']) ? 'bg-green-500' : 'bg-slate-300' }} mr-3"></div>
                                <span class="text-sm {{ in_array($preOrder->status, ['sourced', 'completed']) ? 'text-slate-900' : 'text-slate-400' }}">Item sourced</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $preOrder->status === 'completed' ? 'bg-green-500' : 'bg-slate-300' }} mr-3"></div>
                                <span class="text-sm {{ $preOrder->status === 'completed' ? 'text-slate-900' : 'text-slate-400' }}">Completed</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    @if($preOrder->estimated_price || $preOrder->final_price)
                        <div class="bg-white rounded-3xl p-6 shadow-lg">
                            <h3 class="text-lg font-bold text-slate-800 mb-4">Pricing</h3>
                            <div class="space-y-3">
                                @if($preOrder->estimated_price)
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-600">Estimated Price:</span>
                                        <span class="font-semibold text-slate-900">MVR {{ number_format($preOrder->estimated_price, 2) }}</span>
                                    </div>
                                @endif
                                @if($preOrder->final_price)
                                    <div class="flex justify-between items-center border-t border-slate-200 pt-3">
                                        <span class="text-slate-600">Final Price:</span>
                                        <span class="font-bold text-lg text-green-600">MVR {{ number_format($preOrder->final_price, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Contact Information -->
                    <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-3xl p-6 border border-green-200">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">
                            <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Need Help?
                        </h3>
                        <p class="text-sm text-slate-600 mb-4">
                            We'll contact you via WhatsApp once we have updates about your pre-order.
                        </p>
                        <div class="text-sm text-slate-600">
                            <p><span class="font-semibold">Questions?</span> Message us on WhatsApp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>