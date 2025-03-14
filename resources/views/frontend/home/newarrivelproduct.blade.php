<div class="max-w-7xl mx-auto px-4 py-2">
    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-4">New Arrivals</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <!-- Product Item -->
        <!-- Your existing product item structure -->

        @foreach ($Products as $Product)
            <div
                class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                <!-- Product Image -->
                <div class="w-full aspect-square relative">
                    <!-- Add discount label only if there is a discount -->
                    @if ($Product->discount_price && $Product->discount_price < $Product->price)
                        @php
                            $discountPercent = round(
                                (($Product->price - $Product->discount_price) / $Product->price) * 100,
                            );
                        @endphp
                        <div
                            class="absolute top-0 left-0 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-tr-lg rounded-bl-lg z-10">
                            -{{ $discountPercent }}% OFF
                        </div>
                    @endif
                    <div class="w-full h-full rounded-lg overflow-hidden">
                        <a href="{{ route('product.details', ['id' => $Product->id, 'slug' => $Product->slug]) }}">
                            <img src="{{ asset($Product->thumbnail_image) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                alt="{{ $Product->name }}">
                        </a>
                    </div>
                </div>

                <!-- Top Right Actions -->
                <div
                    class="absolute right-2 top-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <button onclick="handleWishlistClick({{ $Product->id }}); return false;"
                        class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center wishlist-btn-{{ $Product->id }}"
                        data-product-id="{{ $Product->id }}">
                        <i
                            class="ri-heart-{{ in_array($Product->id, array_keys(Session::get('wishlist', []))) ? 'fill text-orange-500' : 'line' }} text-lg"></i>
                    </button>
                    <a href="#"
                        onclick="handleCartClick({{ $Product->id }}, {{ $Product->hasConfiguredAttributes() }}); return false;"
                        class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                        <i class="ri-shopping-cart-line text-lg"></i>
                    </a>
                </div>

                <!-- Product Info -->
                <div class=" mt-2 text-center">
                    <h3 class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate">
                        <a href="{{ route('product.details', ['id' => $Product->id, 'slug' => $Product->slug]) }}">
                            {{ $Product->name }}
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
                            @if ($Product->discount_price && $Product->discount_price < $Product->price)
                                <span class="text-orange-500 font-semibold">৳{{ $Product->discount_price }}</span>
                                <span class="text-gray-400 text-sm line-through">৳{{ $Product->price }}</span>
                            @else
                                <span class="text-orange-500 font-semibold">৳{{ $Product->price }}</span>
                            @endif
                        </div>
                        <a href="#"
                            onclick="handleBuyNow({{ $Product->id }}, {{ $Product->hasConfiguredAttributes() }}); return false;"
                            class="w-full flex items-center justify-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600 transition-colors">
                            <i class="ri-shopping-bag-line"></i>
                            <span>Buy Now</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function handleCartClick(productId, hasAttributes) {
        if (hasAttributes) {
            // Redirect to product details page if product has attributes
            window.location.href = `{{ url('/product-details') }}/${productId}/${productId}`;
            return;
        }

        // Direct add to cart for products without attributes
        addToCart(productId, 1);
    }

    function addToCart(productId, quantity = 1) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
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

                    updateCartDrawer();
                } else {
                    throw new Error(data.message || 'Failed to add product to cart');
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

    function updateCartDrawer() {
        fetch("{{ route('cart.get') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartContent = document.getElementById('cartContent');
                    if (cartContent) {
                        let cartHtml = '';

                        if (Object.keys(data.cart).length > 0) {
                            cartHtml += '<div class="overflow-y-auto max-h-[60vh]">';

                            Object.values(data.cart).forEach(item => {
                                cartHtml += `
                                <div id="cart-item-${item.id}" class="cart-item flex items-center gap-4 border-b py-4" data-base-price="${item.price}">
                                    <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800">${item.name}</h3>
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center border rounded">
                                                <button onclick="updateCartItemQuantity(${item.id}, ${item.quantity - 1})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">-</button>
                                                <span class="quantity-value px-3 py-1">${item.quantity}</span>
                                                <button onclick="updateCartItemQuantity(${item.id}, ${item.quantity + 1})" class="px-2 py-1 text-gray-600 hover:bg-gray-100">+</button>
                                            </div>
                                            <span class="item-price font-medium text-orange-500">৳${(item.price * item.quantity).toFixed(2)}</span>
                                        </div>
                                    </div>
                                    <button onclick="removeFromCart(${item.id})" class="text-gray-400 hover:text-red-500">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>`;
                            });

                            cartHtml += '</div>';

                            // Add subtotal and checkout button
                            cartHtml += `
                            <div class="border-t pt-4 mt-2">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span id="cart-subtotal" class="font-semibold text-orange-500">৳${data.total.toFixed(2)}</span>
                                </div>
                                <a href="{{ route('cart.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                                    View Cart
                                </a>
                            </div>`;
                        } else {
                            cartHtml = '<div class="py-8 text-center text-gray-500">Your cart is empty</div>';
                        }

                        cartContent.innerHTML = cartHtml;
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching cart:', error);
            });
    }

    function removeFromCart(productId) {
        fetch("{{ route('cart.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in UI
                    const cartCounts = document.querySelectorAll('.cart-count');
                    cartCounts.forEach(counter => {
                        counter.textContent = data.cart_count;
                    });

                    // Remove item from the cart drawer
                    const cartItem = document.getElementById(`cart-item-${productId}`);
                    if (cartItem) {
                        cartItem.remove();
                    }

                    // Update subtotal
                    updateCartSubtotal();

                    // Show notification
                    showNotification('Success', data.message, 'success');

                    // If cart is empty, update the drawer
                    if (data.cart_count === 0) {
                        updateCartDrawer();
                    }
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error removing from cart:', error);
                showNotification('Error', 'Failed to remove item from cart', 'error');
            });
    }

    function updateCartItemQuantity(productId, quantity) {
        if (quantity < 1) return;

        fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const quantityElement = document.querySelector(`#cart-item-${productId} .quantity-value`);
                    const priceElement = document.querySelector(`#cart-item-${productId} .item-price`);

                    if (quantityElement) {
                        quantityElement.textContent = quantity;
                    }

                    if (priceElement) {
                        priceElement.textContent = `৳${data.item_total.toFixed(2)}`;
                    }

                    // Update subtotal
                    updateCartSubtotal();
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                showNotification('Error', 'Failed to update cart', 'error');
            });
    }

    function updateCartSubtotal() {
        fetch("{{ route('cart.get') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const subtotalElement = document.getElementById('cart-subtotal');
                    if (subtotalElement) {
                        subtotalElement.textContent = `৳${data.total.toFixed(2)}`;
                    }
                }
            })
            .catch(error => {
                console.error('Error updating subtotal:', error);
            });
    }

    function showNotification(title, message, type) {
        // You can implement a toast notification system here
        // For now, we'll use a simple alert
        alert(`${title}: ${message}`);
    }

    function handleWishlistClick(productId) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const wishlistBtn = document.querySelector(`.wishlist-btn-${productId}`);
        const icon = wishlistBtn.querySelector('i');

        fetch("{{ route('wishlist.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update wishlist count
                    document.querySelectorAll('.wishlist-count').forEach(counter => {
                        counter.textContent = data.wishlist_count;
                    });

                    // Toggle heart icon
                    icon.classList.remove('ri-heart-line');
                    icon.classList.add('ri-heart-fill', 'text-orange-500');

                    // Update wishlist sidebar if it's open
                    updateWishlistDrawer();

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
                } else {
                    // Product already in wishlist
                    Swal.fire({
                        title: 'Info!',
                        text: data.message,
                        icon: 'info',
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
                    title: 'Error!',
                    text: error.message || 'Failed to add product to wishlist',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    }

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
                    credentials: 'same-origin',
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
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong. Please try again.',
                        icon: 'error',
                    });
                });
        }
    }
</script>
