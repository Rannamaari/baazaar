<x-app-layout>
    <x-slot name="title">My Dashboard - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Manage your Baazaar account dashboard. View orders, track deliveries, manage addresses, pre-orders and account settings. Your personal shopping hub in the Maldives.</x-slot>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Welcome back, {{ Auth::user()->name }}! 👋
                </h2>
                <p class="text-slate-600 mt-1">Here's what's happening with your account</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-500">Member since</div>
                <div class="font-semibold text-slate-700">{{ Auth::user()->created_at->format('M Y') }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Total Orders</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->orders()->count() }}</p>
                        </div>
                        <x-heroicon-o-shopping-bag class="h-8 w-8 text-blue-200" />
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Delivered</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->orders()->where('status', 'delivered')->count() }}</p>
                        </div>
                        <x-heroicon-o-check-circle class="h-8 w-8 text-green-200" />
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-100 text-sm font-medium">Pending</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->orders()->where('status', 'pending')->count() }}</p>
                        </div>
                        <x-heroicon-o-clock class="h-8 w-8 text-yellow-200" />
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Addresses</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->addresses()->count() }}</p>
                        </div>
                        <x-heroicon-o-map-pin class="h-8 w-8 text-purple-200" />
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-xl p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Pre-Orders</p>
                            <p class="text-3xl font-bold">{{ Auth::user()->preOrders()->count() }}</p>
                        </div>
                        <x-heroicon-o-shopping-cart class="h-8 w-8 text-orange-200" />
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column - Addresses & Wishlist -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- My Addresses -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                <x-heroicon-o-map-pin class="h-5 w-5 mr-2 text-blue-600" />
                                My Addresses
                            </h3>
                            <a href="{{ route('addresses.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                Manage
                            </a>
                        </div>
                        
                        @if(Auth::user()->addresses()->count() > 0)
                            <div class="space-y-3">
                                @foreach(Auth::user()->addresses()->limit(2)->get() as $address)
                                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="font-medium text-slate-800 text-sm">
                                                    {{ $address->display_name }}
                                                </div>
                                                <div class="text-slate-600 text-xs mt-1">
                                                    {{ $address->full_address }}
                                                </div>
                                            </div>
                                            @if($address->is_default)
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-medium">
                                                    Default
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if(Auth::user()->addresses()->count() > 2)
                                    <div class="text-center">
                                        <span class="text-slate-500 text-sm">
                                            +{{ Auth::user()->addresses()->count() - 2 }} more addresses
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-6">
                                <x-heroicon-o-map-pin class="h-12 w-12 text-slate-300 mx-auto mb-3" />
                                <p class="text-slate-500 text-sm mb-3">No addresses saved yet</p>
                                <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <x-heroicon-o-plus class="h-4 w-4 mr-2" />
                                    Add Address
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- My Pre-Orders -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                <x-heroicon-o-shopping-cart class="h-5 w-5 mr-2 text-orange-600" />
                                My Pre-Orders
                            </h3>
                            <a href="{{ route('pre-orders.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                                View All
                            </a>
                        </div>
                        
                        @if(Auth::user()->preOrders()->count() > 0)
                            <div class="space-y-3">
                                @foreach(Auth::user()->preOrders()->latest()->limit(2)->get() as $preOrder)
                                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="font-medium text-slate-800 text-sm">
                                                    {{ $preOrder->product_name }}
                                                </div>
                                                <div class="text-slate-600 text-xs mt-1">
                                                    {{ $preOrder->created_at->format('M d, Y') }}
                                                </div>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                {{ $preOrder->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $preOrder->status === 'reviewing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $preOrder->status === 'sourcing' ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $preOrder->status === 'sourced' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $preOrder->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ $preOrder->status_label }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @if(Auth::user()->preOrders()->count() > 2)
                                    <div class="text-center">
                                        <span class="text-slate-500 text-sm">
                                            +{{ Auth::user()->preOrders()->count() - 2 }} more pre-orders
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-6">
                                <x-heroicon-o-shopping-cart class="h-12 w-12 text-slate-300 mx-auto mb-3" />
                                <p class="text-slate-500 text-sm mb-3">No pre-orders yet</p>
                                <a href="{{ route('pre-orders.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors">
                                    <x-heroicon-o-plus class="h-4 w-4 mr-2" />
                                    Request Product
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Wishlist (Coming Soon) -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                <x-heroicon-o-heart class="h-5 w-5 mr-2 text-red-500" />
                                Wishlist
                            </h3>
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-medium">
                                Coming Soon
                            </span>
                        </div>
                        
                        <div class="text-center py-6">
                            <x-heroicon-o-heart class="h-12 w-12 text-slate-300 mx-auto mb-3" />
                            <p class="text-slate-500 text-sm">Save your favorite products</p>
                            <p class="text-slate-400 text-xs mt-1">Feature coming soon!</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Orders -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Recent Orders -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-slate-800 flex items-center">
                                <x-heroicon-o-shopping-bag class="h-5 w-5 mr-2 text-blue-600" />
                                Recent Orders
                            </h3>
                            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                View All
                            </a>
                        </div>
                        
                        @if(Auth::user()->orders()->count() > 0)
                            <div class="space-y-4">
                                @foreach(Auth::user()->orders()->latest()->limit(3)->get() as $order)
                                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-lg border border-slate-100">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                @if($order->status === 'delivered')
                                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                                        <x-heroicon-o-check-circle class="h-5 w-5 text-green-600" />
                                                    </div>
                                                @elseif($order->status === 'pending')
                                                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                                        <x-heroicon-o-clock class="h-5 w-5 text-yellow-600" />
                                                    </div>
                                                @elseif($order->status === 'cancelled')
                                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                                        <x-heroicon-o-x-circle class="h-5 w-5 text-red-600" />
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                        <x-heroicon-o-shopping-bag class="h-5 w-5 text-blue-600" />
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-800">
                                                    Order #{{ $order->id }}
                                                </div>
                                                <div class="text-slate-600 text-sm">
                                                    {{ $order->created_at->format('M d, Y') }} • {{ $order->items()->count() }} items
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-slate-800">
                                                {{ number_format($order->grand_total, 2) }} MVR
                                            </div>
                                            <div class="text-sm">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    @if($order->status === 'delivered') bg-green-100 text-green-800
                                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <x-heroicon-o-shopping-bag class="h-16 w-16 text-slate-300 mx-auto mb-4" />
                                <h4 class="text-lg font-medium text-slate-800 mb-2">No orders yet</h4>
                                <p class="text-slate-500 text-sm mb-4">Start shopping to see your orders here</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <x-heroicon-o-shopping-cart class="h-4 w-4 mr-2" />
                                    Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Order Status Summary -->
                    @if(Auth::user()->orders()->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                        <x-heroicon-o-clock class="h-4 w-4 text-yellow-600" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ Auth::user()->orders()->where('status', 'pending')->count() }}</div>
                                        <div class="text-slate-600 text-sm">Pending Orders</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <x-heroicon-o-check-circle class="h-4 w-4 text-green-600" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ Auth::user()->orders()->where('status', 'delivered')->count() }}</div>
                                        <div class="text-slate-600 text-sm">Delivered Orders</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg border border-slate-200 p-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                        <x-heroicon-o-x-circle class="h-4 w-4 text-red-600" />
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ Auth::user()->orders()->where('status', 'cancelled')->count() }}</div>
                                        <div class="text-slate-600 text-sm">Cancelled Orders</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
