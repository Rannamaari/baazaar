<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Your Profile') }}
        </h2>
    </x-slot>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="mb-8">
                <div class="text-8xl mb-6">🎉</div>
                <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">Welcome to Baazaar!</h1>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                    Let's set up your addresses to make checkout faster and easier. 
                    You can always add more addresses later.
                </p>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="mb-12">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold">✓</div>
                    <span class="ml-2 text-sm font-semibold text-green-600">Account Created</span>
                </div>
                <div class="w-16 h-1 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                    <span class="ml-2 text-sm font-semibold text-blue-600">Add Addresses</span>
                </div>
                <div class="w-16 h-1 bg-slate-300"></div>
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-slate-300 text-slate-600 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                    <span class="ml-2 text-sm font-semibold text-slate-500">Start Shopping</span>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl border-2 border-slate-200">
            <form action="{{ route('registration.address-setup') }}" method="POST" class="space-y-12">
                @csrf

                <!-- Contact Information Section -->
                <div class="border-2 border-indigo-200 rounded-2xl p-8 bg-gradient-to-br from-indigo-50 to-blue-50">
                    <div class="flex items-center mb-6">
                        <div class="text-4xl mr-4">📱</div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Contact Information</h2>
                            <p class="text-slate-600">Your phone number for delivery coordination</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Phone Number -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-lg font-semibold text-slate-700 mb-3">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="e.g., +960 123-4567 or 123-4567"
                                   required
                                   class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="border-2 border-green-200 rounded-2xl p-8 bg-gradient-to-br from-green-50 to-blue-50">
                    <div class="flex items-center mb-6">
                        <div class="text-4xl mr-4">📍</div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Delivery Address</h2>
                            <p class="text-slate-600">Your address for product deliveries</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Address Type -->
                        <div class="md:col-span-2">
                            <label class="block text-lg font-semibold text-slate-700 mb-3">
                                Address Type <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="type" 
                                           value="home" 
                                           {{ old('type', 'home') == 'home' ? 'checked' : '' }}
                                           required
                                           class="w-5 h-5 text-blue-600 border-2 border-slate-300 rounded focus:ring-2 focus:ring-blue-200">
                                    <span class="ml-2 text-lg">🏠 Home</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" 
                                           name="type" 
                                           value="office" 
                                           {{ old('type') == 'office' ? 'checked' : '' }}
                                           required
                                           class="w-5 h-5 text-blue-600 border-2 border-slate-300 rounded focus:ring-2 focus:ring-blue-200">
                                    <span class="ml-2 text-lg">🏢 Office</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address Label -->
                        <div class="md:col-span-2">
                            <label for="label" class="block text-lg font-semibold text-slate-700 mb-3">
                                Address Label <span class="text-slate-500 text-sm">(Optional)</span>
                            </label>
                            <input type="text" 
                                   id="label" 
                                   name="label" 
                                   value="{{ old('label') }}"
                                   placeholder="e.g., My Home, My Office, Parents House"
                                   class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            @error('label')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Street Address -->
                        <div class="md:col-span-2">
                            <label for="street_address" class="block text-lg font-semibold text-slate-700 mb-3">
                                Street Address <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="street_address" 
                                   name="street_address" 
                                   value="{{ old('street_address') }}"
                                   placeholder="e.g., House No. 123, Villa Name, Office Building Floor 2"
                                   required
                                   class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            @error('street_address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Road Name -->
                        <div class="md:col-span-2">
                            <label for="road_name" class="block text-lg font-semibold text-slate-700 mb-3">
                                Road Name <span class="text-slate-500 text-sm">(Optional)</span>
                            </label>
                            <input type="text" 
                                   id="road_name" 
                                   name="road_name" 
                                   value="{{ old('road_name') }}"
                                   placeholder="e.g., Ameer Ahmed Magu, Boduthakurufaanu Magu"
                                   class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            @error('road_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Atoll -->
                        <div>
                            <label for="atoll" class="block text-lg font-semibold text-slate-700 mb-3">
                                Atoll <span class="text-red-500">*</span>
                            </label>
                            <select id="atoll" 
                                    name="atoll" 
                                    required
                                    class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                <option value="">Select Atoll</option>
                                @foreach($atolls as $atoll)
                                    <option value="{{ $atoll->name }}" {{ old('atoll') == $atoll->name ? 'selected' : '' }}>
                                        {{ $atoll->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('atoll')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Island -->
                        <div>
                            <label for="island" class="block text-lg font-semibold text-slate-700 mb-3">
                                Island <span class="text-red-500">*</span>
                            </label>
                            <select id="island" 
                                    name="island" 
                                    required
                                    class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                <option value="">Select Island</option>
                            </select>
                            @error('island')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-lg font-semibold text-slate-700 mb-3">
                                Postal Code <span class="text-slate-500 text-sm">(Optional)</span>
                            </label>
                            <input type="text" 
                                   id="postal_code" 
                                   name="postal_code" 
                                   value="{{ old('postal_code') }}"
                                   placeholder="e.g., 20001"
                                   class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            @error('postal_code')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div>
                            <label for="additional_notes" class="block text-lg font-semibold text-slate-700 mb-3">
                                Additional Notes <span class="text-slate-500 text-sm">(Optional)</span>
                            </label>
                            <textarea id="additional_notes" 
                                      name="additional_notes" 
                                      rows="3"
                                      placeholder="e.g., Near the mosque, Behind the school..."
                                      class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ old('additional_notes') }}</textarea>
                            @error('additional_notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-105">
                        <svg class="w-6 h-6 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Complete Setup & Start Shopping
                    </button>
                    
                    <a href="{{ route('registration.skip-address-setup') }}" 
                       class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-200 text-center">
                        Skip for Now
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const atollSelect = document.getElementById('atoll');
    const islandSelect = document.getElementById('island');

    function loadIslands() {
        const atoll = atollSelect.value;
        
        // Clear current islands
        islandSelect.innerHTML = '<option value="">Select Island</option>';
        islandSelect.disabled = !atoll;

        if (!atoll) {
            return;
        }

        // Show loading
        islandSelect.innerHTML = '<option value="">Loading islands...</option>';

        // Fetch islands for selected atoll
        fetch(`/addresses/${encodeURIComponent(atoll)}/islands`)
            .then(response => response.json())
            .then(islands => {
                islandSelect.innerHTML = '<option value="">Select Island</option>';
                
                islands.forEach(island => {
                    const option = document.createElement('option');
                    option.value = island;
                    option.textContent = island;
                    // Restore old value if exists
                    if (island === '{{ old('island') }}') {
                        option.selected = true;
                    }
                    islandSelect.appendChild(option);
                });
                
                islandSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading islands:', error);
                islandSelect.innerHTML = '<option value="">Error loading islands</option>';
            });
    }

    // Add event listener
    atollSelect.addEventListener('change', loadIslands);

    // Load islands if atoll is pre-selected (from old input)
    if (atollSelect.value) {
        loadIslands();
    }
});
</script>

</x-app-layout>
