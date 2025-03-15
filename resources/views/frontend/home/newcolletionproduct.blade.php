<div class="max-w-7xl mx-auto px-4 py-2">
    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-4">New Collections</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @forelse ($Products as $product)
            <div
                class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                <!-- Product Image -->
                <div class="w-full aspect-square relative">
                    @if ($product->discount_price && $product->discount_price < $product->price)
                        @php
                            $discountPercent = round(
                                (($product->price - $product->discount_price) / $product->price) * 100,
                            );
                        @endphp
                        <div
                            class="absolute top-0 left-0 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-tr-lg rounded-bl-lg z-10">
                            -{{ $discountPercent }}% OFF
                        </div>
                    @endif
                    <div class="w-full h-full rounded-lg overflow-hidden">
                        <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                            <img src="{{ asset($product->thumbnail_image) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $product->name }}">
                        </a>
                    </div>
                </div>

                <!-- Top Right Actions -->
                <div
                    class="absolute right-2 top-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <button onclick="handleWishlistClick({{ $product->id }})"
                        class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center {{ in_array($product->id, array_keys(Session::get('wishlist', []))) ? 'text-orange-500 bg-orange-50' : '' }}">
                        <i class="ri-heart-line text-lg"></i>
                    </button>
                    <button onclick="addToCart({{ $product->id }})"
                        class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                        <i class="ri-shopping-cart-line text-lg"></i>
                    </button>
                </div>

                <!-- Product Info -->
                <div class="mt-2 text-center">
                    <h3 class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate">
                        <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                            {{ $product->name }}
                        </a>
                    </h3>
                    <div class="flex items-center justify-center mb-2">
                        <div class="flex text-yellow-400 text-sm">
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-fill"></i>
                            <i class="ri-star-half-fill"></i>
                        </div>
                        <span class="text-xs text-gray-500 ml-2">(45)</span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex items-center justify-center gap-2">
                            @if ($product->discount_price && $product->discount_price < $product->price)
                                <span class="text-orange-500 font-semibold">৳{{ $product->discount_price }}</span>
                                <span class="text-gray-400 text-sm line-through">৳{{ $product->price }}</span>
                            @else
                                <span class="text-orange-500 font-semibold">৳{{ $product->price }}</span>
                            @endif
                        </div>
                        <button
                            onclick="handleBuyNow({{ $product->id }}, {{ $product->hasConfiguredAttributes() ? 'true' : 'false' }})"
                            class="w-full flex items-center justify-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600 transition-colors">
                            <i class="ri-shopping-bag-line"></i>
                            <span>Buy Now</span>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500">No products found</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    function handleBuyNow(productId, hasAttributes) {
        if (hasAttributes) {
            // Redirect to product details page if product has attributes
            window.location.href = `{{ url('/product-details') }}/${productId}/${productId}`;
        } else {
            // Direct checkout for products without attributes
            const quantity = 1;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('checkout.direct') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Something went wrong',
                            icon: 'error',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
        }
    }

    function addToCart(productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update cart count
                    document.querySelectorAll('.cart-count').forEach(counter => {
                        counter.textContent = data.cart_count;
                    });

                    // Track AddToCart event with Facebook Pixel
                    if (data.pixelEvent) {
                        eval(data.pixelEvent);
                    }

                    // Show success notification
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Update cart drawer
                    updateCartDrawer();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Failed to add product to cart',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    }
</script>
