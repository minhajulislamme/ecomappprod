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
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Shopping Cart</h1>

        @if (count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm">
                        @foreach ($cart as $cartKey => $item)
                            <div class="p-6 border-b last:border-b-0" id="cart-item-{{ $cartKey }}">
                                <div class="flex gap-4">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                        class="w-24 h-24 object-cover rounded-lg">

                                    <div class="flex-1">
                                        <div class="flex justify-between mb-2">
                                            <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                                            <button onclick="removeFromCart('{{ $cartKey }}')"
                                                class="text-gray-400 hover:text-red-500">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>

                                        <!-- Product Attributes -->
                                        @if (!empty($item['attributes']))
                                            <div class="flex flex-wrap gap-2 mb-3">
                                                @foreach ($item['attributes'] as $attribute)
                                                    <div
                                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        @if (strtolower($attribute['name']) === 'color')
                                                            <span class="w-3 h-3 rounded-full mr-1.5"
                                                                style="background-color: {{ $attribute['value'] }}"></span>
                                                        @endif
                                                        {{ $attribute['name'] }}: {{ $attribute['value'] }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center border rounded">
                                                <button type="button"
                                                    onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] - 1 }})"
                                                    class="p-2 hover:bg-gray-50">
                                                    <i class="ri-subtract-line"></i>
                                                </button>
                                                <span class="px-4 py-2">{{ $item['quantity'] }}</span>
                                                <button type="button"
                                                    onclick="updateQuantity('{{ $cartKey }}', {{ $item['quantity'] + 1 }})"
                                                    class="p-2 hover:bg-gray-50">
                                                    <i class="ri-add-line"></i>
                                                </button>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-orange-500 font-medium">
                                                    ৳{{ number_format($item['price'] * $item['quantity'], 2) }}
                                                </div>
                                                @if ($item['quantity'] > 1)
                                                    <div class="text-sm text-gray-500">
                                                        ৳{{ number_format($item['price'], 2) }} each
                                                    </div>
                                                @endif
                                                @if ($item['free_shipping'])
                                                    <div class="text-sm text-green-600 flex items-center justify-end mt-1">
                                                        <i class="ri-truck-line mr-1"></i>
                                                        Free Shipping
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Order Summary</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">৳{{ number_format($total, 2) }}</span>
                            </div>

                            <!-- Coupon Section -->
                            <div class="border-t pt-4">
                                <div class="flex gap-2">
                                    <input type="text" id="coupon-code"
                                        class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                        placeholder="Enter coupon code" {{ Session::has('coupon') ? 'disabled' : '' }}>
                                    @if (!Session::has('coupon'))
                                        <button onclick="applyCoupon()"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">
                                            Apply
                                        </button>
                                    @else
                                        <button onclick="removeCoupon()"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                <div id="coupon-message" class="mt-2 text-sm"></div>
                            </div>

                            @if (Session::has('coupon'))
                                <div class="flex justify-between" id="discount-row">
                                    <span class="text-gray-600">
                                        Coupon ({{ Session::get('coupon')['code'] }} -
                                        {{ Session::get('coupon')['discount_percentage'] }}% off)
                                    </span>
                                    <span class="font-medium text-green-600" id="discount-amount">
                                        -৳{{ number_format(Session::get('coupon')['discount'], 2) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-gray-500">Calculated at checkout</span>
                            </div>
                            <div class="border-t pt-4 flex justify-between">
                                <span class="text-gray-800 font-medium">Total</span>
                                <span class="text-xl font-bold text-orange-500" id="final-total">
                                    ৳{{ number_format(Session::has('coupon') ? Session::get('coupon')['new_total'] : $total, 2) }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}"
                            class="block w-full mt-6 bg-orange-500 text-white py-3 px-4 rounded-lg hover:bg-orange-600 transition-colors text-center">
                            Proceed to Checkout
                        </a>

                        <a href="{{ route('shop') }}" class="block text-center mt-4 text-orange-500 hover:text-orange-600">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 mb-6">Your cart is empty</div>
                <a href="{{ route('shop') }}"
                    class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    <i class="ri-shopping-cart-line mr-2"></i>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <script>
        function updateQuantity(cartKey, quantity) {
            if (quantity < 1) return;

            fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: cartKey,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function removeFromCart(cartKey) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This item will be removed from your cart",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('cart.remove') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: cartKey
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: data.message,
                                    icon: 'error',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });
        }

        function applyCoupon() {
            const couponCode = document.getElementById('coupon-code').value;
            const messageDiv = document.getElementById('coupon-message');

            if (!couponCode.trim()) {
                messageDiv.className = 'mt-2 text-sm text-red-600';
                messageDiv.textContent = 'Please enter a coupon code';
                return;
            }

            // Show loading state
            messageDiv.className = 'mt-2 text-sm text-gray-600';
            messageDiv.textContent = 'Applying coupon...';

            fetch("{{ route('cart.apply-coupon') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        coupon_code: couponCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.className = 'mt-2 text-sm text-green-600';
                        messageDiv.textContent = data.message;

                        // Short delay before refresh to show success message
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        messageDiv.className = 'mt-2 text-sm text-red-600';
                        messageDiv.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.className = 'mt-2 text-sm text-red-600';
                    messageDiv.textContent = 'An error occurred while applying the coupon.';
                });
        }

        function removeCoupon() {
            const messageDiv = document.getElementById('coupon-message');

            // Show loading state
            messageDiv.className = 'mt-2 text-sm text-gray-600';
            messageDiv.textContent = 'Removing coupon...';

            fetch("{{ route('cart.remove-coupon') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.className = 'mt-2 text-sm text-green-600';
                        messageDiv.textContent = data.message;

                        // Short delay before refresh to show success message
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.className = 'mt-2 text-sm text-red-600';
                    messageDiv.textContent = 'An error occurred while removing the coupon.';
                });
        }

        // Add event listener for Enter key in the coupon input field
        document.getElementById('coupon-code').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                applyCoupon();
            }
        });
    </script>
@endsection
