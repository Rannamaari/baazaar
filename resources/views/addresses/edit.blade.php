<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Address') }}
        </h2>
    </x-slot>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">✏️ Edit Address</h1>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Update your address information
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl border-2 border-slate-200">
            <form action="{{ route('addresses.update', $address) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Address Type -->
                <div>
                    <label for="type" class="block text-lg font-semibold text-slate-700 mb-3">Address Type</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="home" class="sr-only" {{ $address->type === 'home' ? 'checked' : '' }}>
                            <div class="address-type-card bg-gradient-to-br from-green-50 to-blue-50 border-2 {{ $address->type === 'home' ? 'border-blue-500 bg-blue-50' : 'border-green-200' }} rounded-2xl p-6 text-center transition-all duration-300 hover:shadow-lg">
                                <div class="text-4xl mb-3">🏠</div>
                                <div class="text-lg font-bold text-slate-800">Home Address</div>
                                <div class="text-sm text-slate-600">Your residential address</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="office" class="sr-only" {{ $address->type === 'office' ? 'checked' : '' }}>
                            <div class="address-type-card bg-gradient-to-br from-purple-50 to-pink-50 border-2 {{ $address->type === 'office' ? 'border-blue-500 bg-blue-50' : 'border-purple-200' }} rounded-2xl p-6 text-center transition-all duration-300 hover:shadow-lg">
                                <div class="text-4xl mb-3">🏢</div>
                                <div class="text-lg font-bold text-slate-800">Office Address</div>
                                <div class="text-sm text-slate-600">Your work address</div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom Label -->
                <div>
                    <label for="label" class="block text-lg font-semibold text-slate-700 mb-3">
                        Custom Label <span class="text-slate-500 text-sm">(Optional)</span>
                    </label>
                    <input type="text" 
                           id="label" 
                           name="label" 
                           value="{{ old('label', $address->label) }}"
                           placeholder="e.g., My Home, Work Office, Mom's House"
                           class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                    @error('label')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Street Address -->
                <div>
                    <label for="street_address" class="block text-lg font-semibold text-slate-700 mb-3">
                        Street Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="street_address" 
                           name="street_address" 
                           value="{{ old('street_address', $address->street_address) }}"
                           placeholder="e.g., House No. 123, Villa Name"
                           required
                           class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                    @error('street_address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Road Name -->
                <div>
                    <label for="road_name" class="block text-lg font-semibold text-slate-700 mb-3">
                        Road Name <span class="text-slate-500 text-sm">(Optional)</span>
                    </label>
                    <input type="text" 
                           id="road_name" 
                           name="road_name" 
                           value="{{ old('road_name', $address->road_name) }}"
                           placeholder="e.g., Ameer Ahmed Magu, Boduthakurufaanu Magu"
                           class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                    @error('road_name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Atoll and Island -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Atoll -->
                    <div>
                        <label for="atoll" class="block text-lg font-semibold text-slate-700 mb-3">
                            Atoll <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="atoll" 
                               name="atoll" 
                               value="{{ old('atoll', $address->atoll) }}"
                               placeholder="e.g., Haa Alif, Kaafu, Alif Alif"
                               required
                               class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                        <p class="mt-1 text-sm text-slate-500">Enter your atoll name (e.g., Male, Haa Alif, Addu)</p>
                        @error('atoll')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Island -->
                    <div>
                        <label for="island" class="block text-lg font-semibold text-slate-700 mb-3">
                            Island <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="island" 
                               name="island" 
                               value="{{ old('island', $address->island) }}"
                               placeholder="e.g., Male, Hulhumale, Dhiffushi"
                               required
                               class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                        <p class="mt-1 text-sm text-slate-500">Enter your island name</p>
                        @error('island')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-lg font-semibold text-slate-700 mb-3">
                        Postal Code <span class="text-slate-500 text-sm">(Optional)</span>
                    </label>
                    <input type="text" 
                           id="postal_code" 
                           name="postal_code" 
                           value="{{ old('postal_code', $address->postal_code) }}"
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
                              rows="4"
                              placeholder="e.g., Near the mosque, Behind the school, Landmark details..."
                              class="w-full px-6 py-4 border-2 border-slate-200 rounded-2xl text-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none">{{ old('additional_notes', $address->additional_notes) }}</textarea>
                    @error('additional_notes')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Set as Default -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_default" 
                           name="is_default" 
                           value="1"
                           {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-2 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_default" class="ml-3 text-lg font-semibold text-slate-700">
                        Set as default {{ $address->type }} address
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-105">
                        <svg class="w-6 h-6 mr-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Address
                    </button>
                    
                    <a href="{{ route('addresses.index') }}" 
                       class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Address type selection
    const typeInputs = document.querySelectorAll('input[name="type"]');
    const typeCards = document.querySelectorAll('.address-type-card');
    
    typeInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            typeCards.forEach(card => {
                card.classList.remove('border-blue-500', 'bg-blue-50');
                card.classList.add('border-slate-200');
            });
            
            if (this.checked) {
                typeCards[index].classList.add('border-blue-500', 'bg-blue-50');
                typeCards[index].classList.remove('border-slate-200');
            }
        });
    });

    // Atoll-Island dependency
    const atollSelect = document.getElementById('atoll');
    const islandSelect = document.getElementById('island');
    const currentIsland = '{{ old("island", $address->island) }}';
    
    // Function to load islands for an atoll
    function loadIslands(atollName, selectedIsland = null) {
        // Clear island options
        islandSelect.innerHTML = '<option value="">Select Island</option>';
        
        if (atollName) {
            // Fetch islands for selected atoll via AJAX
            fetch(`/addresses/${encodeURIComponent(atollName)}/islands`)
                .then(response => response.json())
                .then(islands => {
                    islands.forEach(island => {
                        const option = document.createElement('option');
                        option.value = island;
                        option.textContent = island;
                        if (selectedIsland && selectedIsland === island) {
                            option.selected = true;
                        }
                        islandSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching islands:', error);
                });
        }
    }
    
    // Load islands for current atoll on page load
    if (atollSelect.value) {
        loadIslands(atollSelect.value, currentIsland);
    }
    
    atollSelect.addEventListener('change', function() {
        loadIslands(this.value);
    });
});
</script>
</x-app-layout>
