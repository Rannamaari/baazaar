<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Addresses') }}
        </h2>
    </x-slot>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-800 mb-6">📍 My Addresses</h1>
            <p class="text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                Manage your home and office addresses for easy checkout
            </p>
        </div>

        <!-- Add Address Button -->
        <div class="mb-8 text-center">
            <a href="{{ route('addresses.create') }}" 
               class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-110">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Address
            </a>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($addresses->count() > 0)
            <!-- Addresses Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($addresses as $address)
                    <div class="bg-white rounded-3xl p-8 shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-105 border-2 border-slate-200 hover:border-blue-400 relative overflow-hidden">
                        <!-- Address Type Badge -->
                        <div class="absolute top-6 right-6">
                            @if($address->type === 'home')
                                <span class="bg-gradient-to-r from-green-400 to-blue-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                    🏠 Home
                                </span>
                            @else
                                <span class="bg-gradient-to-r from-purple-400 to-pink-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                    🏢 Office
                                </span>
                            @endif
                        </div>

                        <!-- Default Badge -->
                        @if($address->is_default)
                            <div class="absolute top-6 left-6">
                                <span class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                    ⭐ Default
                                </span>
                            </div>
                        @endif

                        <div class="mt-8">
                            <!-- Address Label -->
                            @if($address->label)
                                <h3 class="text-2xl font-bold text-slate-800 mb-4">{{ $address->label }}</h3>
                            @else
                                <h3 class="text-2xl font-bold text-slate-800 mb-4">{{ ucfirst($address->type) }} Address</h3>
                            @endif

                            <!-- Address Details -->
                            <div class="space-y-3 text-slate-600">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 mr-3 mt-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">{{ $address->street_address }}</p>
                                        @if($address->road_name)
                                            <p class="text-sm">{{ $address->road_name }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $address->island }}, {{ $address->atoll }}</span>
                                </div>

                                @if($address->postal_code)
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span>{{ $address->postal_code }}</span>
                                    </div>
                                @endif

                                @if($address->additional_notes)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 mr-3 mt-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        <p class="text-sm">{{ $address->additional_notes }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex flex-wrap gap-3">
                                <a href="{{ route('addresses.edit', $address) }}" 
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200 text-center">
                                    Edit
                                </a>
                                
                                @if(!$address->is_default)
                                    <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200">
                                            Set Default
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200"
                                            onclick="return confirm('Are you sure you want to delete this address?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mb-8">
                    <div class="text-8xl mb-6">📍</div>
                    <h3 class="text-3xl font-bold text-slate-800 mb-4">No Addresses Yet</h3>
                    <p class="text-xl text-slate-600 mb-8 max-w-2xl mx-auto">
                        Add your home and office addresses to make checkout faster and easier. 
                        You can add multiple addresses and set one as default.
                    </p>
                </div>
                
                <a href="{{ route('addresses.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-110">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Your First Address
                </a>
            </div>
        @endif
    </div>
</div>
</x-app-layout>
