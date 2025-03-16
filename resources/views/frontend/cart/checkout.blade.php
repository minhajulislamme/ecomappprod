@extends('frontend.frontend')
@section('content')
    <!-- GTM Data Layer -->
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            ecommerce: null
        }); // Clear previous ecommerce object
        dataLayer.push({!! json_encode($gtmData) !!});
    </script>

    <!-- Facebook Pixel event handler -->
    @if (isset($pixelEvent))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                {!! $pixelEvent !!}
            });
        </script>
    @endif

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Checkout Form Section -->
            <div class="lg:col-span-2 space-y-6">
                <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                    @csrf
                    <!-- Contact Information -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-4">Contact Information</h2>
                        <div class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                    <span class="text-red-500 text-xs error-message" id="error-first_name"></span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                    <span class="text-red-500 text-xs error-message" id="error-last_name"></span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                <span class="text-red-500 text-xs error-message" id="error-email"></span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="tel" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                <span class="text-red-500 text-xs error-message" id="error-phone"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                <span class="text-red-500 text-xs error-message" id="error-address"></span>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                    <span class="text-red-500 text-xs error-message" id="error-city"></span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-orange-400">
                                    <span class="text-red-500 text-xs error-message" id="error-postal_code"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Charge -->
                    @if (!$hasOnlyFreeShipping)
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-semibold mb-4">Shipping Charge</h2>
                            <div class="space-y-4">
                                @foreach ($shippingCharges as $charge)
                                    <div class="flex items-center space-x-3 p-4 border border-gray-200 rounded-md">
                                        <input type="radio" name="shipping_charge_id" id="shipping_{{ $charge->id }}"
                                            value="{{ $charge->id }}" data-charge="{{ $charge->charge }}"
                                            {{ $loop->first ? 'checked' : '' }} required class="shipping-method-radio">
                                        <label for="shipping_{{ $charge->id }}" class="flex-1">
                                            <span class="font-medium">{{ $charge->name }}</span>
                                            <div class="text-sm text-gray-500 mt-1">
                                                ৳{{ number_format($charge->charge, 2) }}</div>
                                        </label>
                                    </div>
                                @endforeach
                                <span class="text-red-500 text-xs error-message" id="error-shipping_charge_id"></span>
                            </div>
                        </div>
                    @else
                        <div class="bg-white p-6 rounded-lg shadow-sm">
                            <h2 class="text-xl font-semibold mb-4">Shipping</h2>
                            <div class="flex items-center space-x-3 p-4 border border-gray-200 rounded-md bg-green-50">
                                <i class="ri-truck-line text-green-500 text-xl"></i>
                                <div class="flex-1">
                                    <span class="font-medium text-green-600">Free Shipping</span>
                                    <div class="text-sm text-green-500 mt-1">Your order qualifies for free shipping!</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Payment Method -->
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-4 border border-gray-200 rounded-md">
                                <input type="radio" name="payment_type" id="online" value="online"
                                    {{ old('payment_type') == 'online' ? 'checked' : '' }} required>
                                <label for="online" class="flex-1">
                                    <span class="font-medium">Online Payment</span>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-6">
                                        <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard" class="h-6">
                                        <img src="{{ asset('images/amex.png') }}" alt="American Express" class="h-6">
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-center space-x-3 p-4 border border-gray-200 rounded-md">
                                <input type="radio" name="payment_type" id="cod" value="cod"
                                    {{ old('payment_type') == 'cod' ? 'checked' : '' }}>
                                <label for="cod" class="flex-1">
                                    <span class="font-medium">Cash on Delivery</span>
                                    <div class="text-sm text-gray-500 mt-1">Pay when you receive the order</div>
                                </label>
                            </div>
                            <span class="text-red-500 text-xs error-message" id="error-payment_type"></span>
                        </div>
                    </div>

                    <!-- Order Summary (Mobile) -->
                    <div class="lg:hidden mt-6">
                        <div class="bg-white p-6 rounded-lg shadow-sm sticky top-20" id="order-summary">
                            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                            <!-- Order Items -->
                            <div class="space-y-4 mb-4" id="cart-items">
                                @foreach ($cart as $itemKey => $item)
                                    <div class="flex items-center space-x-4 cart-item"
                                        data-item-key="{{ $itemKey }}">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                            class="w-20 h-20 object-cover rounded">
                                        <div class="flex-1">
                                            <div class="flex justify-between">
                                                <h3 class="font-medium">{{ $item['name'] }}</h3>
                                                <button type="button"
                                                    class="text-gray-400 hover:text-red-500 remove-item"
                                                    data-item-id="{{ $itemKey }}"
                                                    onclick="removeCartItem('{{ $itemKey }}')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </div>

                                            <!-- Product Attributes -->
                                            @if (!empty($item['attributes']))
                                                <div class="flex flex-wrap gap-2 mt-1 mb-2">
                                                    @foreach ($item['attributes'] as $attribute)
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">
                                                            @if (strtolower($attribute['name']) === 'color')
                                                                <span class="w-3 h-3 rounded-full mr-1.5"
                                                                    style="background-color: {{ $attribute['value'] }}"></span>
                                                            @endif
                                                            {{ $attribute['name'] }}: {{ $attribute['value'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between mt-2">
                                                <div class="flex items-center">
                                                    <button type="button"
                                                        class="quantity-btn decrease-quantity p-2 text-gray-500 hover:text-orange-500 hover:bg-gray-100 rounded-l border border-r-0 border-gray-200"
                                                        data-item-id="{{ $itemKey }}">
                                                        <i class="ri-subtract-line"></i>
                                                    </button>
                                                    <input type="number"
                                                        class="quantity-input w-14 text-center border-y border-gray-200 py-2 focus:outline-none focus:border-orange-500 focus:ring-0"
                                                        value="{{ $item['quantity'] }}" min="1" max="99"
                                                        data-item-id="{{ $itemKey }}"
                                                        style="-moz-appearance: textfield;">
                                                    <button type="button"
                                                        class="quantity-btn increase-quantity p-2 text-gray-500 hover:text-orange-500 hover:bg-gray-100 rounded-r border border-l-0 border-gray-200"
                                                        data-item-id="{{ $itemKey }}">
                                                        <i class="ri-add-line"></i>
                                                    </button>
                                                </div>
                                                <p class="text-orange-500 font-medium item-total">
                                                    ৳{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Empty Cart Message (Hidden by default) -->
                            <div id="empty-cart-message" class="text-center py-6 hidden">
                                <i class="ri-shopping-cart-line text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">Your cart is empty</p>
                                <a href="{{ route('shop') }}"
                                    class="inline-block mt-4 px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors">
                                    Continue Shopping
                                </a>
                            </div>

                            <!-- Price Details -->
                            <div class="border-t border-gray-200 pt-4 space-y-2" id="price-details">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium" id="subtotal">৳{{ number_format($total, 2) }}</span>
                                </div>
                                @if (Session::has('coupon'))
                                    <div class="flex justify-between text-sm" id="coupon-discount">
                                        <span class="text-gray-600">
                                            Coupon ({{ Session::get('coupon')['code'] }} -
                                            {{ Session::get('coupon')['discount_percentage'] }}%
                                            off)
                                        </span>
                                        <span class="font-medium text-green-600" id="discount-amount">
                                            -৳{{ number_format(Session::get('coupon')['discount'], 2) }}
                                        </span>
                                    </div>
                                @endif
                                @if (!$hasOnlyFreeShipping)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-medium" id="shipping">
                                            ৳{{ number_format($shippingCharges->first()->charge ?? 0, 2) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Shipping</span>
                                        <span class="font-medium text-green-600">Free</span>
                                    </div>
                                @endif
                                <div class="flex justify-between font-semibold text-lg pt-2 border-t border-gray-200">
                                    <span>Total</span>
                                    <span class="text-orange-500" id="total">
                                        ৳{{ number_format(
                                            $total -
                                                (Session::has('coupon') ? Session::get('coupon')['discount'] : 0) +
                                                (!$hasOnlyFreeShipping ? $shippingCharges->first()->charge ?? 0 : 0),
                                            2,
                                        ) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="place-order-btn"
                        class="w-full bg-orange-500 text-white py-3 rounded-md mt-6 hover:bg-orange-600 transition-colors">
                        Place Order
                    </button>

                    <!-- Loading indicator (hidden by default) -->
                    <div id="loading-indicator" class="hidden w-full mt-4 text-center">
                        <div
                            class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-orange-500">
                        </div>
                        <p class="mt-2 text-gray-600">Processing your order...</p>
                    </div>
                </form>
            </div>

            <!-- Order Summary (Desktop) -->
            <div class="hidden lg:block">
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-20" id="order-summary">
                    <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                    <!-- Order Items -->
                    <div class="space-y-4 mb-4" id="cart-items">
                        @foreach ($cart as $itemKey => $item)
                            <div class="flex items-center space-x-4 cart-item" data-item-key="{{ $itemKey }}">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="w-20 h-20 object-cover rounded">
                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-medium">{{ $item['name'] }}</h3>
                                        <button type="button" class="text-gray-400 hover:text-red-500 remove-item"
                                            data-item-id="{{ $itemKey }}"
                                            onclick="removeCartItem('{{ $itemKey }}')">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>

                                    <!-- Product Attributes -->
                                    @if (!empty($item['attributes']))
                                        <div class="flex flex-wrap gap-2 mt-1 mb-2">
                                            @foreach ($item['attributes'] as $attribute)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">
                                                    @if (strtolower($attribute['name']) === 'color')
                                                        <span class="w-3 h-3 rounded-full mr-1.5"
                                                            style="background-color: {{ $attribute['value'] }}"></span>
                                                    @endif
                                                    {{ $attribute['name'] }}: {{ $attribute['value'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between mt-2">
                                        <div class="flex items-center">
                                            <button type="button"
                                                class="quantity-btn decrease-quantity p-2 text-gray-500 hover:text-orange-500 hover:bg-gray-100 rounded-l border border-r-0 border-gray-200"
                                                data-item-id="{{ $itemKey }}">
                                                <i class="ri-subtract-line"></i>
                                            </button>
                                            <input type="number"
                                                class="quantity-input w-14 text-center border-y border-gray-200 py-2 focus:outline-none focus:border-orange-500 focus:ring-0"
                                                value="{{ $item['quantity'] }}" min="1" max="99"
                                                data-item-id="{{ $itemKey }}" style="-moz-appearance: textfield;">
                                            <button type="button"
                                                class="quantity-btn increase-quantity p-2 text-gray-500 hover:text-orange-500 hover:bg-gray-100 rounded-r border border-l-0 border-gray-200"
                                                data-item-id="{{ $itemKey }}">
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </div>
                                        <p class="text-orange-500 font-medium item-total">
                                            ৳{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Empty Cart Message (Hidden by default) -->
                    <div id="empty-cart-message" class="text-center py-6 hidden">
                        <i class="ri-shopping-cart-line text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Your cart is empty</p>
                        <a href="{{ route('shop') }}"
                            class="inline-block mt-4 px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition-colors">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Price Details -->
                    <div class="border-t border-gray-200 pt-4 space-y-2" id="price-details">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" id="subtotal">৳{{ number_format($total, 2) }}</span>
                        </div>
                        @if (Session::has('coupon'))
                            <div class="flex justify-between text-sm" id="coupon-discount">
                                <span class="text-gray-600">
                                    Coupon ({{ Session::get('coupon')['code'] }} -
                                    {{ Session::get('coupon')['discount_percentage'] }}%
                                    off)
                                </span>
                                <span class="font-medium text-green-600" id="discount-amount">
                                    -৳{{ number_format(Session::get('coupon')['discount'], 2) }}
                                </span>
                            </div>
                        @endif
                        @if (!$hasOnlyFreeShipping)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium" id="shipping">
                                    ৳{{ number_format($shippingCharges->first()->charge ?? 0, 2) }}
                                </span>
                            </div>
                        @else
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-green-600">Free</span>
                            </div>
                        @endif
                        <div class="flex justify-between font-semibold text-lg pt-2 border-t border-gray-200">
                            <span>Total</span>
                            <span class="text-orange-500" id="total">
                                ৳{{ number_format(
                                    $total -
                                        (Session::has('coupon') ? Session::get('coupon')['discount'] : 0) +
                                        (!$hasOnlyFreeShipping ? $shippingCharges->first()->charge ?? 0 : 0),
                                    2,
                                ) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Redirect to shop if cart is empty -->
    @if (count($cart) === 0)
        <script>
            window.location.href = "{{ route('shop') }}";
        </script>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial update of shipping charge
            @if (!$hasOnlyFreeShipping)
                const initialShipping = document.querySelector('input[name="shipping_charge_id"]:checked');
                if (initialShipping) {
                    const initialCharge = parseFloat(initialShipping.getAttribute('data-charge'));
                    updateShippingAndTotal(initialCharge);
                }
            @endif

            // Handle item removal
            const removeButtons = document.querySelectorAll('.remove-item');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    removeCartItem(itemId);
                });
            });

            // Update shipping method handler
            @if (!$hasOnlyFreeShipping)
                const shippingRadios = document.querySelectorAll('.shipping-method-radio');
                shippingRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const shippingCharge = parseFloat(this.getAttribute('data-charge'));
                        updateShippingAndTotal(shippingCharge);
                    });
                });
            @endif

            // Form submission handler
            const checkoutForm = document.getElementById('checkout-form');
            let isSubmitting = false; // Add flag to prevent double submission

            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Prevent double submission
                if (isSubmitting) {
                    return;
                }
                isSubmitting = true;

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => {
                    el.textContent = '';
                });

                // Show loading indicator
                document.getElementById('place-order-btn').classList.add('hidden');
                document.getElementById('loading-indicator').classList.remove('hidden');

                fetch('{{ route('checkout.store') }}', {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Redirect to success page
                            window.location.href = data.redirect;
                        } else {
                            // Show errors
                            document.getElementById('place-order-btn').classList.remove('hidden');
                            document.getElementById('loading-indicator').classList.add('hidden');

                            if (data.errors) {
                                Object.keys(data.errors).forEach(key => {
                                    const errorEl = document.getElementById('error-' + key);
                                    if (errorEl) {
                                        errorEl.textContent = data.errors[key][0];
                                    }
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('place-order-btn').classList.remove('hidden');
                        document.getElementById('loading-indicator').classList.add('hidden');
                    })
                    .finally(() => {
                        isSubmitting = false; // Reset submission flag
                    });
            });

            // Initialize the first selected shipping method's charge to the total
            const selectedShipping = document.querySelector('input[name="shipping_charge_id"]:checked');
            if (selectedShipping) {
                const shippingCharge = parseFloat(selectedShipping.getAttribute('data-charge'));
                updateTotal(shippingCharge);
            } else {
                // Select first shipping method if none is selected
                const firstShippingMethod = document.querySelector('input[name="shipping_charge_id"]');
                if (firstShippingMethod) {
                    firstShippingMethod.checked = true;
                    const shippingCharge = parseFloat(firstShippingMethod.getAttribute('data-charge'));
                    updateTotal(shippingCharge);
                }
            }

            // New function to update shipping and total
            function updateShippingAndTotal(shippingCharge) {
                // Get the subtotal value
                const subtotalElement = document.querySelector('#subtotal');
                if (!subtotalElement) return;

                let subtotal = parseFloat(subtotalElement.textContent.replace('৳', '').replace(/,/g, ''));

                // Check for discount
                let discount = 0;
                const discountElement = document.querySelector('#discount-amount');
                if (discountElement) {
                    discount = parseFloat(discountElement.textContent.replace('-৳', '').replace(/,/g, ''));
                }

                @if (!$hasOnlyFreeShipping)
                    // Update shipping display in all summaries
                    const shippingElements = document.querySelectorAll('#shipping');
                    shippingElements.forEach(element => {
                        if (element) {
                            element.textContent = '৳' + shippingCharge.toFixed(2);
                        }
                    });
                @endif

                // Calculate and update total in all summaries
                const total = subtotal - discount + (
                    @if (!$hasOnlyFreeShipping)
                        shippingCharge
                    @else
                        0
                    @endif );
                const totalElements = document.querySelectorAll('#total');
                totalElements.forEach(element => {
                    if (element) {
                        element.textContent = '৳' + total.toFixed(2);
                    }
                });
            }

            // Replace existing updateTotal function with updateShippingAndTotal
            function updateTotal(shippingCharge) {
                updateShippingAndTotal(shippingCharge);
            }

            // Update the updateTotalAfterRemove function
            function updateTotalAfterRemove(newTotal) {
                const selectedShipping = document.querySelector('input[name="shipping_charge_id"]:checked');
                if (selectedShipping) {
                    const shippingCharge = parseFloat(selectedShipping.getAttribute('data-charge'));
                    updateShippingAndTotal(shippingCharge);
                }
            }

            // Handle item removal from Order Summary
            function removeCartItem(cartKey) {
                // Show loading toast
                const loadingToast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    didOpen: (toast) => {
                        toast.showLoading();
                    }
                });

                loadingToast.fire({
                    title: 'Removing item...'
                });

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
                            // Remove item from DOM
                            const items = document.querySelectorAll(
                                `.cart-item[data-item-key="${cartKey}"]`);
                            items.forEach(item => {
                                item.style.transition = 'all 0.3s ease';
                                item.style.opacity = '0';
                                setTimeout(() => item.remove(), 300);
                            });

                            // Update cart count
                            document.querySelectorAll('.cart-count').forEach(counter => {
                                counter.textContent = data.cart_count;
                            });

                            // Update totals
                            document.querySelectorAll('#subtotal').forEach(element => {
                                element.textContent = '৳' + data.subtotal.toFixed(2);
                            });

                            if (data.discount > 0) {
                                document.querySelectorAll('#discount-amount').forEach(element => {
                                    element.textContent = '-৳' + data.discount.toFixed(2);
                                });
                            }

                            document.querySelectorAll('#shipping').forEach(element => {
                                element.textContent = '৳' + data.shipping_charge.toFixed(2);
                            });

                            document.querySelectorAll('#total').forEach(element => {
                                element.textContent = '৳' + data.total.toFixed(2);
                            });

                            // Show success notification
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Item removed successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Redirect to shop if cart is empty
                            if (data.empty) {
                                setTimeout(() => {
                                    window.location.href = "{{ route('shop') }}";
                                }, 1500);
                            }
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.message || 'Failed to remove item',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Something went wrong! Please try again.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
            }

            // Remove all duplicate removeCartItem functions
            // ...existing code...

            // Add quantity update handlers
            function initQuantityControls() {
                document.querySelectorAll('.quantity-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const itemId = this.getAttribute('data-item-id');
                        const input = document.querySelector(
                            `.quantity-input[data-item-id="${itemId}"]`);
                        let currentValue = parseInt(input.value);

                        if (this.classList.contains('increase-quantity')) {
                            if (currentValue < 99) {
                                currentValue++;
                                updateCartItemQuantity(itemId, currentValue);
                            }
                        } else {
                            if (currentValue > 1) {
                                currentValue--;
                                updateCartItemQuantity(itemId, currentValue);
                            }
                        }
                    });
                });

                document.querySelectorAll('.quantity-input').forEach(input => {
                    // Prevent mousewheel from changing number
                    input.addEventListener('wheel', function(e) {
                        e.preventDefault();
                    });

                    input.addEventListener('change', function() {
                        const itemId = this.getAttribute('data-item-id');
                        let value = parseInt(this.value);

                        if (isNaN(value) || value < 1) {
                            value = 1;
                        } else if (value > 99) {
                            value = 99;
                        }

                        this.value = value;
                        updateCartItemQuantity(itemId, value);
                    });

                    // Prevent non-numeric input
                    input.addEventListener('keypress', function(e) {
                        if (!/[0-9]/.test(e.key)) {
                            e.preventDefault();
                        }
                    });
                });
            }

            function updateCartItemQuantity(itemId, quantity) {
                const loadingToast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    didOpen: (toast) => {
                        toast.showLoading();
                    }
                });

                loadingToast.fire({
                    title: 'Updating quantity...'
                });

                fetch("{{ route('cart.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: itemId,
                            quantity: quantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update all instances of this item's quantity input
                            document.querySelectorAll(`.quantity-input[data-item-id="${itemId}"]`).forEach(
                                input => {
                                    input.value = quantity;
                                });

                            // Update totals
                            document.querySelectorAll('#subtotal').forEach(element => {
                                element.textContent = '৳' + data.subtotal.toFixed(2);
                            });

                            if (data.discount > 0) {
                                document.querySelectorAll('#discount-amount').forEach(element => {
                                    element.textContent = '-৳' + data.discount.toFixed(2);
                                });
                            }

                            document.querySelectorAll('#total').forEach(element => {
                                element.textContent = '৳' + data.total.toFixed(2);
                            });

                            // Update item total price
                            document.querySelectorAll(`.cart-item[data-item-key="${itemId}"] .item-total`)
                                .forEach(element => {
                                    element.textContent = '৳' + data.item_total.toFixed(2);
                                });

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Quantity updated',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to update quantity',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
            }

            // Initialize quantity controls
            initQuantityControls();
        });
    </script>
@endsection
