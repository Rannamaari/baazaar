<x-app-layout>
    <x-slot name="title">Checkout - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Complete your order at Baazaar Maldives. Secure checkout with COD and bank transfer options. Fast delivery across all atolls in the Maldives.</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Order Summary</h3>
                        
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                    <div class="flex-1">
                                        <h4 class="font-medium">{{ $item['product']->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            MVR {{ number_format($item['product']->price, 2) }} × {{ $item['qty'] }}
                                        </p>
                                    </div>
                                    <div class="font-medium">
                                        MVR {{ number_format($item['subtotal'], 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>MVR {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping:</span>
                                <span>{{ $shippingTotal == 0 ? 'Free' : 'MVR ' . number_format($shippingTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax:</span>
                                <span>MVR {{ number_format($taxTotal, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between text-lg font-semibold">
                                    <span>Total:</span>
                                    <span>MVR {{ number_format($grandTotal, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
                        
                        <form action="{{ route('checkout.place') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Customer Information -->
                            <div>
                                <h4 class="font-medium mb-3">Customer Details</h4>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <p class="font-medium">{{ auth()->user()->name }}</p>
                                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                                    @if(auth()->user()->phone)
                                        <p class="text-gray-600">📱 {{ auth()->user()->phone }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer transition-colors">
                                        <input type="radio" name="payment_method" value="cash" 
                                               class="form-radio h-4 w-4 text-blue-600" required>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">Cash on Delivery</div>
                                            <div class="text-sm text-gray-500">Pay when you receive your order</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-4 border border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer transition-colors">
                                        <input type="radio" name="payment_method" value="bank_transfer" 
                                               class="form-radio h-4 w-4 text-blue-600">
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">Bank Transfer</div>
                                            <div class="text-sm text-gray-500">Upload payment slip after transfer</div>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Slip Upload (shown when bank transfer is selected) -->
                            <div id="payment-slip-section" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Slip</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                                    <input type="file" name="payment_slip" id="payment_slip" accept="image/*,.pdf" class="hidden">
                                    <label for="payment_slip" class="cursor-pointer">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium text-blue-600 hover:text-blue-500">Click to upload</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, PDF up to 2MB</p>
                                        </div>
                                    </label>
                                </div>
                                @error('payment_slip')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Delivery Information -->
                            <div>
                                <h4 class="font-medium mb-3">Delivery Information</h4>
                                <div class="space-y-4">
                                    <!-- Address Selection -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Select Delivery Address</label>
                                        
                                        @if($addresses->count() > 0)
                                            <div class="space-y-3">
                                                @foreach($addresses as $address)
                                                    <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 cursor-pointer transition-all duration-200 {{ $address->is_default ? 'border-blue-500 bg-blue-50' : '' }}">
                                                        <input type="radio" 
                                                               name="delivery_address_id" 
                                                               value="{{ $address->id }}" 
                                                               class="form-radio h-4 w-4 text-blue-600 mt-1" 
                                                               {{ $address->is_default ? 'checked' : '' }}
                                                               required>
                                                        <div class="ml-3 flex-1">
                                                            <div class="flex items-center justify-between">
                                                                <div class="font-medium text-gray-900">
                                                                    @if($address->label)
                                                                        {{ $address->label }}
                                                                    @else
                                                                        {{ ucfirst($address->type) }} Address
                                                                    @endif
                                                                </div>
                                                                @if($address->is_default)
                                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">Default</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-sm text-gray-600 mt-1">
                                                                {{ $address->street_address }}
                                                                @if($address->road_name)
                                                                    , {{ $address->road_name }}
                                                                @endif
                                                            </div>
                                                            <div class="text-sm text-gray-600">
                                                                {{ $address->island }}, {{ $address->atoll }}
                                                            </div>
                                                            @if($address->additional_notes)
                                                                <div class="text-sm text-gray-500 mt-1">
                                                                    {{ $address->additional_notes }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                            
                                            <!-- Add New Address Link -->
                                            <div class="mt-4 text-center">
                                                <a href="{{ route('addresses.create') }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    + Add New Address
                                                </a>
                                            </div>
                                        @else
                                            <!-- No addresses - redirect to add address -->
                                            <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                                                <div class="text-4xl mb-4">📍</div>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Addresses Found</h3>
                                                <p class="text-gray-600 mb-4">Please add an address to continue with checkout.</p>
                                                <a href="{{ route('addresses.create') }}" 
                                                   class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                                    Add Address
                                                </a>
                                            </div>
                                        @endif
                                        
                                        @error('delivery_address_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Phone Number -->
                                    <div>
                                        <label for="delivery_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                        <input type="tel" 
                                               name="delivery_phone" 
                                               id="delivery_phone" 
                                               value="{{ old('delivery_phone', auth()->user()->phone) }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               placeholder="Enter your phone number" 
                                               required>
                                        @error('delivery_phone')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Order Note -->
                            <div>
                                <div class="bg-blue-50 p-4 rounded-md">
                                    <p class="text-sm text-blue-800">
                                        <strong>Note:</strong> We will contact you after placing the order to confirm delivery details and payment.
                                    </p>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 font-medium text-lg">
                                    Place Order - MVR {{ number_format($grandTotal, 2) }}
                                </button>
                            </div>
                        </form>

                        <div class="mt-4">
                            <a href="{{ route('cart.index') }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">
                                ← Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const paymentSlipSection = document.getElementById('payment-slip-section');
            const paymentSlipInput = document.getElementById('payment_slip');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'bank_transfer') {
                        paymentSlipSection.classList.remove('hidden');
                        paymentSlipInput.required = true;
                    } else {
                        paymentSlipSection.classList.add('hidden');
                        paymentSlipInput.required = false;
                        paymentSlipInput.value = '';
                    }
                });
            });

            // Handle file upload preview
            paymentSlipInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const label = this.nextElementSibling;
                    const fileName = file.name;
                    label.innerHTML = `
                        <svg class="mx-auto h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600 font-medium">${fileName}</p>
                            <p class="text-xs text-gray-500">Click to change file</p>
                        </div>
                    `;
                }
            });
        });
    </script>
</x-app-layout>