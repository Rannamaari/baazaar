<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6">
                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Thank You for Your Order!</h1>
                <p class="text-xl text-gray-600">Your order has been successfully placed</p>
            </div>

            <!-- Order Details Card -->
            @if($order)
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Order Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Order Information</h3>
                                <div class="space-y-2 text-gray-600">
                                    <p><span class="font-medium">Order ID:</span> #{{ $order->id }}</p>
                                    <p><span class="font-medium">Order Date:</span>
                                        {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                                    <p><span class="font-medium">Payment Method:</span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->payment_method === 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ $order->payment_method === 'cash' ? 'Cash on Delivery' : 'Bank Transfer' }}
                                        </span>
                                    </p>
                                    <p><span class="font-medium">Payment Status:</span>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                ($order->payment_status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Delivery Information</h3>
                                <div class="space-y-2 text-gray-600">
                                    <p><span class="font-medium">Address:</span> {{ $order->delivery_address }}</p>
                                    <p><span class="font-medium">Phone:</span> {{ $order->delivery_phone }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-gray-500">Quantity: {{ $item->qty }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900">MVR {{ number_format($item->line_total, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 pt-6 border-t">
                                <div class="flex justify-between items-center text-xl font-semibold text-gray-900">
                                    <span>Total Amount:</span>
                                    <span>MVR {{ number_format($order->grand_total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

            <!-- Next Steps Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">What's Next?</h2>

                <div class="space-y-6">
                    @if($order && $order->payment_method === 'cash')
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Cash on Delivery</h3>
                                <p class="text-gray-600">Our delivery team will contact you shortly to confirm your order
                                    and arrange delivery. Payment will be collected upon delivery.</p>
                            </div>
                        </div>
                    @elseif($order && $order->payment_method === 'bank_transfer')
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-yellow-100">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Payment Verification</h3>
                                <p class="text-gray-600">Our team is reviewing your payment slip. Once verified, we'll
                                    process your order and contact you for delivery arrangements.</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Customer Support</h3>
                            <p class="text-gray-600">Baazaar staff will contact you within 24 hours to confirm your
                                order details and provide delivery updates.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                        </svg>
                        Continue Shopping
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        View Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>