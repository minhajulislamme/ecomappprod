@extends('frontend.frontend')
@section('content')
    <!-- Facebook Pixel ViewCart event -->
    @if (isset($pixelEvent))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                {!! $pixelEvent !!}
            });
        </script>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Cart Items Section -->
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <h1 class="text-2xl font-semibold mb-6">Shopping Cart</h1>

                <!-- Cart Items -->
                <div class="space-y-4" id="cart-items">
                    @forelse ($cart as $key => $item)
                        <div class="bg-white p-4 rounded-lg shadow-sm cart-item" data-item-key="{{ $key }}">
                            <!-- Cart item content -->
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="w-24 h-24 object-cover rounded-md">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-medium text-lg text-gray-800">{{ $item['name'] }}</h3>
                                        <button type="button" class="text-gray-400 hover:text-red-500"
                                            onclick="removeCartItem('{{ $key }}')">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>

                                    <!-- Product Attributes -->
                                    @if (!empty($item['attributes']))
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @foreach ($item['attributes'] as $attribute)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $attribute['name'] }}: {{ $attribute['value'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between mt-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-600">Quantity:</span>
                                            <div class="flex items-center border rounded-lg">
                                                <button type="button" class="px-3 py-1 hover:bg-gray-100 rounded-l"
                                                    onclick="updateQuantity('{{ $key }}', 'decrease')">-</button>
                                                <input type="number" value="{{ $item['quantity'] }}" min="1"
                                                    class="w-16 text-center border-x py-1"
                                                    onchange="updateQuantity('{{ $key }}', 'input', this.value)">
                                                <button type="button" class="px-3 py-1 hover:bg-gray-100 rounded-r"
                                                    onclick="updateQuantity('{{ $key }}', 'increase')">+</button>
                                            </div>
                                        </div>
                                        <span
                                            class="text-orange-500 font-semibold">৳{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="mb-4">
                                <i class="ri-shopping-cart-line text-5xl text-gray-300"></i>
                            </div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Your cart is empty</h2>
                            <p class="text-gray-600 mb-6">Looks like you haven't added anything to your cart yet.</p>
                            <a href="{{ route('shop') }}"
                                class="inline-block bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition-colors">
                                Start Shopping
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Order Summary -->
            @if (count($cart) > 0)
                <div class="lg:w-96">
                    <div class="bg-white p-6 rounded-lg shadow-sm sticky top-20">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                        <!-- Coupon Section -->
                        <div class="mb-6">
                            <div class="flex space-x-2">
                                <input type="text" id="coupon-code" placeholder="Enter coupon code"
                                    class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:border-orange-500">
                                <button onclick="applyCoupon()"
                                    class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                    Apply
                                </button>
                            </div>
                        </div>

                        <!-- Summary Details -->
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">৳{{ number_format($total, 2) }}</span>
                            </div>

                            @if (Session::has('coupon'))
                                <div class="flex justify-between text-green-600">
                                    <span>Coupon ({{ Session::get('coupon')['code'] }})</span>
                                    <span>-৳{{ number_format(Session::get('coupon')['discount'], 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between pt-3 border-t text-lg font-semibold">
                                <span>Total</span>
                                <span class="text-orange-500">
                                    ৳{{ number_format($total - (Session::has('coupon') ? Session::get('coupon')['discount'] : 0), 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <a href="{{ route('checkout') }}"
                            class="block w-full text-center bg-orange-500 text-white px-6 py-3 rounded-lg mt-6 hover:bg-orange-600 transition-colors">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Handle removing items from cart
        function removeCartItem(cartKey) {
            // Remove item implementation
        }

        // Handle quantity updates
        function updateQuantity(cartKey, action, value = null) {
            // Update quantity implementation
        }

        // Handle coupon application
        function applyCoupon() {
            // Apply coupon implementation
        }
    </script>
@endsection
