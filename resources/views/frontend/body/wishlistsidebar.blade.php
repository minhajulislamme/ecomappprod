<div id="wishlistSidebar" class="fixed inset-0 bg-black/50 z-[100] hidden">
    <div id="wishlistContent"
        class="fixed top-0 right-0 bottom-0 w-80 md:w-96 bg-white transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden flex flex-col">
        <!-- Wishlist Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-3">
                <i class="ri-heart-line text-2xl text-orange-400"></i>
                <span class="text-xl font-semibold">Wishlist (<span
                        class="wishlist-count">{{ count(Session::get('wishlist', [])) }}</span>)</span>
            </div>
            <button class="text-gray-500 hover:text-orange-400" onclick="toggleWishlist()">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Wishlist Items -->
        <div class="flex-1 overflow-y-auto p-4">
            @php
                $wishlist = Session::get('wishlist', []);
            @endphp

            @if (count($wishlist) > 0)
                <div class="space-y-4">
                    @foreach ($wishlist as $productId => $item)
                        <div id="wishlist-item-{{ $productId }}" class="wishlist-item flex gap-4 border-b pb-4">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
                                    <button onclick="removeWishlistItem({{ $productId }})"
                                        class="text-gray-400 hover:text-red-500">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                                <div class="mt-1 text-orange-500 font-medium">৳{{ number_format($item['price'], 2) }}
                                </div>
                                <div class="mt-2">
                                    <button onclick="moveWishlistItemToCart({{ $productId }})"
                                        class="text-sm text-blue-500 hover:text-blue-600 flex items-center">
                                        <i class="ri-shopping-cart-line mr-1"></i>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center text-gray-500">Your wishlist is empty</div>
            @endif
        </div>

        <!-- Wishlist Footer -->
        <div class="p-4 border-t">
            <a href="{{ route('wishlist.view') }}"
                class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                View Wishlist
            </a>
            @if (count($wishlist) > 0)
                <button onclick="moveAllWishlistToCart()"
                    class="w-full mt-2 py-2 px-4 border border-orange-400 text-orange-500 text-center rounded-md hover:bg-orange-50 transition-colors">
                    Move All to Cart
                </button>
            @endif
        </div>
    </div>
</div>

<script>
    function updateWishlistDrawer() {
        fetch("{{ route('wishlist.get') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const wishlistContent = document.getElementById('wishlistContent').querySelector('.p-4');
                    if (wishlistContent) {
                        let wishlistHtml = '';

                        if (Object.keys(data.wishlist).length > 0) {
                            wishlistHtml += '<div class="space-y-4">';

                            Object.entries(data.wishlist).forEach(([productId, item]) => {
                                wishlistHtml += `
                                <div id="wishlist-item-${productId}" class="wishlist-item flex gap-4 border-b pb-4">
                                    <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="font-medium text-gray-800">${item.name}</h4>
                                            <button onclick="removeWishlistItem(${productId})" class="text-gray-400 hover:text-red-500">
                                                <i class="ri-close-line text-xl"></i>
                                            </button>
                                        </div>
                                        <div class="mt-1 text-orange-500 font-medium">৳${parseFloat(item.price).toFixed(2)}</div>
                                        <div class="mt-2">
                                            <button onclick="moveWishlistItemToCart(${productId})" class="text-sm text-blue-500 hover:text-blue-600 flex items-center">
                                                <i class="ri-shopping-cart-line mr-1"></i>
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>`;
                            });

                            wishlistHtml += '</div>';
                        } else {
                            wishlistHtml =
                                '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';
                        }

                        wishlistContent.innerHTML = wishlistHtml;

                        // Update footer
                        const footerHtml = `
                            <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                                View Wishlist
                            </a>
                            ${Object.keys(data.wishlist).length > 0 ? `
                                <button onclick="moveAllWishlistToCart()" class="w-full mt-2 py-2 px-4 border border-orange-400 text-orange-500 text-center rounded-md hover:bg-orange-50 transition-colors">
                                    Move All to Cart
                                </button>
                            ` : ''}
                        `;

                        document.getElementById('wishlistContent').querySelector('.border-t').innerHTML =
                            footerHtml;
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching wishlist:', error);
            });
    }

    function removeWishlistItem(productId) {
        fetch("{{ route('wishlist.remove') }}", {
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
                    // Remove the item from DOM immediately
                    const itemElement = document.getElementById(`wishlist-item-${productId}`);
                    if (itemElement) {
                        itemElement.remove();
                    }

                    // Update wishlist count in header
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(el => {
                        el.textContent = data.wishlist_count;
                    });

                    // If the wishlist is now empty, update the wishlist content
                    if (data.wishlist_count === 0) {
                        const wishlistContent = document.getElementById('wishlistContent').querySelector(
                            '.flex-1.overflow-y-auto.p-4');
                        wishlistContent.innerHTML =
                            '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';

                        // Update footer to remove "Move All to Cart" button
                        document.getElementById('wishlistContent').querySelector('.border-t').innerHTML = `
                        <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                            View Wishlist
                        </a>
                    `;
                    }

                    // Dispatch a custom event for the wishlist view page to handle
                    document.dispatchEvent(new CustomEvent('wishlistItemRemoved', {
                        detail: {
                            productId: productId,
                            wishlistCount: data.wishlist_count
                        }
                    }));

                    // Show success toast or notification (if you have a notification system)
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Success',
                            text: data.message || 'Product removed from wishlist',
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else {
                        console.log('Product removed from wishlist');
                    }
                } else {
                    console.error('Failed to remove product from wishlist');
                }
            })
            .catch(error => {
                console.error('Error removing product from wishlist:', error);
            });
    }

    function moveWishlistItemToCart(productId) {
        fetch("{{ route('wishlist.move-to-cart') }}", {
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
                    // Remove the item from wishlist DOM
                    const itemElement = document.getElementById(`wishlist-item-${productId}`);
                    if (itemElement) {
                        itemElement.remove();
                    }

                    // Update wishlist count in header
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(el => {
                        el.textContent = data.wishlist_count;
                    });

                    // Update cart count if you have a cart count display
                    if (document.querySelector('.cart-count')) {
                        document.querySelector('.cart-count').textContent = data.cart_count;
                    }

                    // If the wishlist is now empty, update the wishlist content
                    if (data.wishlist_count === 0) {
                        const wishlistContent = document.getElementById('wishlistContent').querySelector(
                            '.flex-1.overflow-y-auto.p-4');
                        wishlistContent.innerHTML =
                            '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';

                        // Update footer to remove "Move All to Cart" button
                        document.getElementById('wishlistContent').querySelector('.border-t').innerHTML = `
                        <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                            View Wishlist
                        </a>
                    `;
                    }

                    // Dispatch a custom event for the wishlist view page to handle
                    document.dispatchEvent(new CustomEvent('wishlistItemRemoved', {
                        detail: {
                            productId: productId,
                            wishlistCount: data.wishlist_count
                        }
                    }));

                    // Show success toast or notification
                    console.log('Product moved to cart');
                } else {
                    console.error('Failed to move product to cart');
                }
            })
            .catch(error => {
                console.error('Error moving product to cart:', error);
            });
    }

    function moveAllWishlistToCart() {
        fetch("{{ route('wishlist.move-all-to-cart') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the wishlist items from DOM
                    const wishlistContent = document.getElementById('wishlistContent').querySelector(
                        '.flex-1.overflow-y-auto.p-4');
                    wishlistContent.innerHTML =
                        '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';

                    // Update wishlist count in header
                    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
                    wishlistCountElements.forEach(el => {
                        el.textContent = '0';
                    });

                    // Update cart count if you have a cart count display
                    if (document.querySelector('.cart-count')) {
                        document.querySelector('.cart-count').textContent = data.cart_count;
                    }

                    // Update footer to remove "Move All to Cart" button
                    document.getElementById('wishlistContent').querySelector('.border-t').innerHTML = `
                    <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                        View Wishlist
                    </a>
                `;

                    // Show success toast or notification
                    console.log('All products moved to cart');
                } else {
                    console.error('Failed to move all products to cart');
                }
            })
            .catch(error => {
                console.error('Error moving all products to cart:', error);
            });
    }
</script>
