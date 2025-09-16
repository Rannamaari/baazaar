<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Pre-Orders') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-purple-50 via-indigo-50 to-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">My Pre-Orders</h1>
                    <p class="text-slate-600 mt-2">Track the status of your special requests</p>
                </div>
                <a href="{{ route('pre-orders.create') }}" 
                   class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Pre-Order
                </a>
            </div>

            @if($preOrders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-3xl p-12 shadow-lg text-center">
                    <div class="text-6xl mb-6">📦</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">No pre-orders yet</h3>
                    <p class="text-slate-600 mb-8 text-lg">
                        Ready to request something special? We'll help you find exactly what you need.
                    </p>
                    <a href="{{ route('pre-orders.create') }}" 
                       class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-lg transition-all duration-300">
                        Make Your First Request
                    </a>
                </div>
            @else
                <!-- Pre-Orders Grid -->
                <div class="space-y-6">
                    @foreach($preOrders as $preOrder)
                        <div class="bg-white rounded-3xl p-6 shadow-lg hover:shadow-xl transition-all duration-300">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Product Info -->
                                <div class="flex-1 mb-4 lg:mb-0">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="text-xl font-bold text-slate-800 flex-1 mr-4">
                                            {{ $preOrder->product_name }}
                                        </h3>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $preOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $preOrder->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $preOrder->status === 'sourcing' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $preOrder->status === 'sourced' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $preOrder->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $preOrder->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                                            {{ $preOrder->status_label }}
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-600">
                                        @if($preOrder->brand)
                                            <div>
                                                <span class="font-semibold">Brand:</span> {{ $preOrder->brand }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-semibold">Requested:</span> {{ $preOrder->created_at->format('M j, Y') }}
                                        </div>
                                        @if($preOrder->estimated_price)
                                            <div>
                                                <span class="font-semibold">Est. Price:</span> MVR {{ number_format($preOrder->estimated_price, 2) }}
                                            </div>
                                        @endif
                                        @if($preOrder->final_price)
                                            <div>
                                                <span class="font-semibold">Final Price:</span> MVR {{ number_format($preOrder->final_price, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center space-x-3">
                                    <a href="{{ $preOrder->product_url }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        View Product
                                        <svg class="w-4 h-4 ml-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('pre-orders.show', $preOrder) }}" 
                                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                        View Details
                                    </a>
                                </div>
                            </div>

                            @if($preOrder->additional_details)
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-sm text-slate-600">
                                        <span class="font-semibold">Additional Details:</span>
                                        {{ Str::limit($preOrder->additional_details, 200) }}
                                    </p>
                                </div>
                            @endif

                            @if($preOrder->admin_notes)
                                <div class="mt-4 pt-4 border-t border-slate-200">
                                    <p class="text-sm text-slate-700">
                                        <span class="font-semibold">Update from our team:</span>
                                        {{ $preOrder->admin_notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($preOrders->hasPages())
                    <div class="mt-8">
                        {{ $preOrders->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>