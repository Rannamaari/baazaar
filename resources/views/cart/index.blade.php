<x-app-layout>
    <x-slot name="title">Shopping Cart - Baazaar Maldives</x-slot>
    <x-slot name="metaDescription">Review your shopping cart at Baazaar Maldives. Update quantities, remove items, and proceed to secure checkout. COD and bank transfer payment options available.</x-slot>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">
                <div class="p-6">
                    @if(count($cartItems) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-16 w-16">
                                                        <div class="h-16 w-16 bg-gray-200 rounded"></div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <a href="{{ route('product.show', $item['product']->slug) }}"
                                                                class="hover:text-blue-600">
                                                                {{ $item['product']->name }}
                                                            </a>
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item['product']->category->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                MVR {{ number_format($item['product']->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $item['product']) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <select name="qty" onchange="this.form.submit()"
                                                        class="rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-medium">
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $i == $item['qty'] ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                MVR {{ number_format($item['subtotal'], 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <form action="{{ route('cart.remove', $item['product']) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800 font-semibold transition-colors duration-200"
                                                        onclick="return confirm('Remove this item from cart?')">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 bg-slate-50 rounded-xl p-6 border border-slate-200">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-xl font-semibold text-slate-700">Total:</span>
                                <span class="text-3xl font-bold text-slate-900">MVR {{ number_format($total, 2) }}</span>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('home') }}"
                                    class="flex-1 bg-slate-600 text-white text-center px-6 py-3 rounded-lg hover:bg-slate-700 font-semibold transition-all duration-200">
                                    Continue Shopping
                                </a>

                                <form action="{{ route('cart.clear') }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold transition-all duration-200"
                                        onclick="return confirm('Are you sure you want to clear your cart?')">
                                        Clear Cart
                                    </button>
                                </form>

                                @auth
                                    <a href="{{ route('checkout.index') }}"
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold transition-all duration-200 hover:scale-105 shadow-lg">
                                        Proceed to Checkout
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold transition-all duration-200 hover:scale-105 shadow-lg">
                                        Login to Checkout
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-slate-400 text-8xl mb-6">🛒</div>
                            <h3 class="text-xl font-semibold text-slate-800 mb-3">Your cart is empty</h3>
                            <p class="text-slate-500 mb-8 text-lg">Add some products to get started!</p>
                            <a href="{{ route('home') }}"
                                class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold transition-all duration-200 hover:scale-105 shadow-lg">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>