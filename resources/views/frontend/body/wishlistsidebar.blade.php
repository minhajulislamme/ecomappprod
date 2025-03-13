<div id="wishlistSidebar" class="fixed inset-0 bg-black/50 z-[100] hidden transition-opacity duration-300">
    <div id="wishlistContent"
        class="fixed top-0 right-0 bottom-0 w-80 md:w-96 bg-white transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden flex flex-col"
        tabindex="-1" role="dialog" aria-labelledby="wishlistTitle">
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-3">
                <i class="ri-heart-line text-2xl text-orange-400"></i>
                <h2 id="wishlistTitle" class="text-xl font-semibold">Wishlist (<span
                        class="wishlist-count">{{ count(Session::get('wishlist', [])) }}</span>)</h2>
            </div>
            <button class="text-gray-500 hover:text-orange-400 p-2 rounded-full hover:bg-gray-100 transition-colors"
                onclick="toggleWishlist()" aria-label="Close wishlist">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Loading State -->
        <div id="wishlistLoading" class="hidden flex-1 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-orange-500 border-t-transparent"></div>
        </div>

        <!-- Wishlist Items -->
        <div class="flex-1 overflow-y-auto p-4" id="wishlistItems">
            @php
                $wishlist = Session::get('wishlist', []);
            @endphp

            @if (count($wishlist) > 0)
                <div class="space-y-4">
                    @foreach ($wishlist as $productId => $item)
                        <div id="wishlist-item-{{ $productId }}" class="wishlist-item flex gap-4 border-b pb-4">
                            <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
                                    <button onclick="removeWishlistItem({{ $productId }})"
                                        class="text-gray-400 hover:text-red-500">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    @if (isset($item['discount_price']) && $item['discount_price'] > 0 && $item['discount_price'] < $item['price'])
                                        <span
                                            class="text-orange-500 font-medium">৳{{ number_format($item['discount_price'], 2) }}</span>
                                        <span
                                            class="text-gray-400 text-sm line-through ml-2">৳{{ number_format($item['price'], 2) }}</span>
                                    @else
                                        <span
                                            class="text-orange-500 font-medium">৳{{ number_format($item['price'], 2) }}</span>
                                    @endif
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
        <div class="p-4 border-t bg-white">
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
    function toggleWishlist() {
        const sidebar = document.getElementById('wishlistSidebar');
        const content = document.getElementById('wishlistContent');
        const loading = document.getElementById('wishlistLoading');
        const items = document.getElementById('wishlistItems');

        if (sidebar.classList.contains('hidden')) {
            // Open wishlist
            sidebar.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => content.classList.remove('translate-x-full'), 10);

            // Show loading state
            loading.classList.remove('hidden');
            items.classList.add('hidden');

            // Update content
            updateWishlistDrawer().finally(() => {
                loading.classList.add('hidden');
                items.classList.remove('hidden');
            });
        } else {
            // Close wishlist
            content.classList.add('translate-x-full');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => sidebar.classList.add('hidden'), 300);
        }
    }

    // Close wishlist when clicking overlay
    document.getElementById('wishlistSidebar').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            toggleWishlist();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('wishlistSidebar').classList.contains('hidden')) {
            toggleWishlist();
        }
    });

    function updateWishlistCounts(count) {
        document.querySelectorAll('.wishlist-count').forEach(el => {
            el.textContent = count;
        });
    }

    function updateWishlistDrawer() {
        return fetch("{{ route('wishlist.get') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const wishlistItemsContainer = document.getElementById('wishlistContent').querySelector(
                        '.flex-1.overflow-y-auto.p-4');
                    const footerContainer = document.getElementById('wishlistContent').querySelector('.border-t');

                    if (wishlistItemsContainer) {
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

                        wishlistItemsContainer.innerHTML = wishlistHtml;

                        // Update footer based on wishlist state
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
                        footerContainer.innerHTML = footerHtml;

                        // Update wishlist count
                        updateWishlistCounts(Object.keys(data.wishlist).length);
                    }
                }
                return data;
            })
            .catch(error => {
                console.error('Error fetching wishlist:', error);
                throw error;
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
                    // Update counts everywhere
                    updateWishlistCounts(data.wishlist_count);

                    // Remove item from sidebar
                    const sidebarItem = document.getElementById(`wishlist-item-${productId}`);
                    if (sidebarItem) {
                        sidebarItem.remove();
                    }

                    // Update main wishlist view if it exists
                    const mainViewItem = document.getElementById(`wishlist-grid-item-${productId}`);
                    if (mainViewItem) {
                        mainViewItem.remove();
                    }

                    // Check if wishlist is empty
                    if (data.wishlist_count === 0) {
                        const emptyMessage =
                            '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';

                        // Update sidebar content
                        document.querySelector('#wishlistContent .flex-1.overflow-y-auto.p-4').innerHTML =
                            emptyMessage;

                        // Update main view if it exists
                        const mainWishlist = document.getElementById('wishlist-items');
                        if (mainWishlist) {
                            mainWishlist.innerHTML =
                                `<div class="col-span-full text-center py-8 text-gray-500">Your wishlist is empty</div>`;
                        }
                    }

                    // Update footer
                    const footer = document.querySelector('#wishlistContent .border-t');
                    if (footer) {
                        footer.innerHTML = `
                        <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                            View Wishlist
                        </a>
                        ${data.wishlist_count > 0 ? `
                            <button onclick="moveAllWishlistToCart()" class="w-full mt-2 py-2 px-4 border border-orange-400 text-orange-500 text-center rounded-md hover:bg-orange-50 transition-colors">
                                Move All to Cart
                            </button>
                        ` : ''}
                    `;
                    }

                    // Show success notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            })
            .catch(error => console.error('Error:', error));
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
                    updateWishlistCounts(data.wishlist_count);
                    updateWishlistDrawer();

                    // Update cart count if exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cart_count;
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Product moved to cart',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            })
            .catch(error => console.error('Error:', error));
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
