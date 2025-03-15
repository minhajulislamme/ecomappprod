@extends('frontend.frontend')
@section('content')
    <!-- Facebook Pixel Purchase Event -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fbq('track', 'Purchase', {
                content_ids: {!! json_encode($order->orderItems->pluck('product_id')->toArray()) !!},
                content_type: 'product',
                value: {{ $order->amount }},
                currency: 'BDT',
                num_items: {{ $order->orderItems->sum('quantity') }},
                contents: {!! json_encode(
                    $order->orderItems->map(function ($item) {
                        return [
                            'id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'item_price' => $item->price,
                        ];
                    }),
                ) !!},
                order_id: '{{ $order->order_number }}'
            });
        });
    </script>

    <div class="max-w-7xl mx-auto px-4 py-8 md:py-12">
        <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="ri-check-line text-4xl md:text-5xl text-green-500"></i>
                </div>
            </div>

            <!-- Success Message -->
            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-2">Order Completed!</h1>
                <p class="text-gray-600">Thank you for your purchase. Your order has been successfully placed.</p>
            </div>

            <!-- Order Details -->
            <div class="border rounded-lg p-4 md:p-6 mb-6">
                <h2 class="text-lg md:text-xl font-semibold mb-4">Order Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Order Number:</p>
                        <p class="font-semibold">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Order Date:</p>
                        <p class="font-semibold">{{ $order->order_date }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Payment Method:</p>
                        <p class="font-semibold">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Amount:</p>
                        <p class="font-semibold">৳{{ number_format($order->amount, 2) }}</p>
                    </div>
                </div>

                <!-- Ordered Products -->
                <div class="mt-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Ordered Products</h3>
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                                <img src="{{ asset($item->product->thumbnail_image) }}" alt="{{ $item->product->name }}"
                                    class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-md">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $item->product->name }}</h4>
                                    @if (!empty($item->attribute_values))
                                        <p class="text-sm text-gray-600">
                                            @foreach (json_decode($item->attribute_values, true) as $attribute)
                                                {{ $attribute['name'] }}: {{ $attribute['value'] }}
                                                @if (!$loop->last)
                                                    |
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-orange-500 font-semibold">৳{{ number_format($item->price, 2) }}</p>
                                        <p class="text-gray-600">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-6 border-t pt-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>৳{{ number_format($order->amount + ($order->coupon_discount ?? 0), 2) }}</span>
                            </div>
                            @if ($order->coupon_discount)
                                <div class="flex justify-between text-gray-600">
                                    <span>Discount</span>
                                    <span>-৳{{ number_format($order->coupon_discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                @if ($order->shipping_charge > 0)
                                    <span>৳{{ number_format($order->shipping_charge, 2) }}</span>
                                @else
                                    <span class="text-green-600 font-medium">Free</span>
                                @endif
                            </div>
                            <div class="flex justify-between font-semibold text-gray-800 text-lg pt-2 border-t">
                                <span>Total</span>
                                <span>৳{{ number_format($order->amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="border rounded-lg p-4 md:p-6 mb-6">
                <h2 class="text-lg md:text-xl font-semibold mb-4">Shipping Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Delivery Address:</p>
                        <p class="font-semibold">{{ $order->name }}</p>
                        <p class="text-gray-600">{{ $order->address }}</p>
                        <p class="text-gray-600">{{ $order->city }}, {{ $order->postal_code }}</p>
                        <p class="text-gray-600">Phone: {{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Order Status:</p>
                        <p class="font-semibold capitalize">{{ $order->status }}</p>
                        @if ($order->status === 'pending')
                            <p class="text-gray-600 mt-1">Your order is being processed</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('shop') }}"
                    class="bg-orange-500 text-white px-6 py-3 rounded-md hover:bg-orange-600 transition-colors text-center">
                    Continue Shopping
                </a>
                @auth
                    <a href="{{ route('user.dashboard') }}"
                        class="bg-gray-100 border text-orange-500 px-6 py-3 rounded-md hover:bg-orange-600 hover:text-white transition-colors text-center">
                        View Order History
                    </a>
                @endauth
            </div>
        </div>
    </div>
@endsection
