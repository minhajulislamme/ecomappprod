@extends('frontend.frontend')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">My Wishlist</h1>

        @if (count($wishlist) > 0)
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-600">{{ count($wishlist) }} Items</span>
                        <button onclick="moveAllToCart()"
                            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition-colors">
                            Move All to Cart
                        </button>
                    </div>

                    <div class="space-y-6">
                        @foreach ($wishlist as $productId => $item)
                            <div id="main-wishlist-item-{{ $productId }}"
                                class="flex items-center gap-4 pb-6 border-b last:border-b-0">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="w-24 h-24 object-cover rounded-lg">

                                <div class="flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                                        <button onclick="removeFromWishlist({{ $productId }})"
                                            class="text-gray-400 hover:text-red-500">
                                            <i class="ri-close-line text-xl"></i>
                                        </button>
                                    </div>
                                    <div class="mt-1 text-orange-500 font-medium">৳{{ number_format($item['price'], 2) }}
                                    </div>
                                    <button onclick="moveToCart({{ $productId }})"
                                        class="mt-2 text-blue-500 hover:text-blue-600 flex items-center text-sm">
                                        <i class="ri-shopping-cart-line mr-1"></i>
                                        Move to Cart
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 mb-6">Your wishlist is empty</div>
                <a href="{{ route('shop') }}"
                    class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    <i class="ri-shopping-cart-line mr-2"></i>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <script>
        function removeFromWishlist(productId) {
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
                        // Remove from main wishlist page
                        const mainWishlistItem = document.getElementById(`main-wishlist-item-${productId}`);
                        if (mainWishlistItem) {
                            mainWishlistItem.remove();
                        }

                        // Update sidebar wishlist item if it exists
                        const sidebarItem = document.getElementById(`wishlist-item-${productId}`);
                        if (sidebarItem) {
                            sidebarItem.remove();
                        }

                        // Update counts everywhere
                        document.querySelectorAll('.wishlist-count').forEach(counter => {
                            counter.textContent = data.wishlist_count;
                        });

                        // Update the item count display if it exists
                        const itemCountDisplay = document.querySelector('.text-gray-600');
                        if (itemCountDisplay) {
                            itemCountDisplay.textContent = `${data.wishlist_count} Items`;
                        }

                        // Check if wishlist is empty and update the view without reload
                        if (data.wishlist_count === 0) {
                            const container = document.querySelector('.max-w-7xl');
                            container.innerHTML = `
                                <h1 class="text-2xl font-bold text-gray-800 mb-8">My Wishlist</h1>
                                <div class="text-center py-12">
                                    <div class="text-gray-500 mb-6">Your wishlist is empty</div>
                                    <a href="{{ route('shop') }}"
                                        class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                        <i class="ri-shopping-cart-line mr-2"></i>
                                        Start Shopping
                                    </a>
                                </div>`;

                            // Update sidebar if it's open
                            if (document.getElementById('wishlistSidebar') && !document.getElementById(
                                    'wishlistSidebar').classList.contains('hidden')) {
                                const wishlistContent = document.getElementById('wishlistContent').querySelector(
                                    '.flex-1.overflow-y-auto.p-4');
                                if (wishlistContent) {
                                    wishlistContent.innerHTML =
                                        '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';
                                }

                                const sidebarFooter = document.getElementById('wishlistContent').querySelector(
                                    '.border-t');
                                if (sidebarFooter) {
                                    sidebarFooter.innerHTML = `
                                    <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                                        View Wishlist
                                    </a>`;
                                }
                            }
                        }

                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
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
                });
        }

        // Listen for custom events from the sidebar
        document.addEventListener('wishlistItemRemoved', function(e) {
            const productId = e.detail.productId;
            const mainWishlistItem = document.getElementById(`main-wishlist-item-${productId}`);
            if (mainWishlistItem) {
                mainWishlistItem.remove();
            }

            // Update the item count display if it exists
            const itemCountDisplay = document.querySelector('.text-gray-600');
            if (itemCountDisplay && e.detail.wishlistCount !== undefined) {
                itemCountDisplay.textContent = `${e.detail.wishlistCount} Items`;
            }

            // Check if wishlist is empty and update the view
            if (e.detail.wishlistCount === 0) {
                const container = document.querySelector('.max-w-7xl');
                if (container) {
                    container.innerHTML = `
                        <h1 class="text-2xl font-bold text-gray-800 mb-8">My Wishlist</h1>
                        <div class="text-center py-12">
                            <div class="text-gray-500 mb-6">Your wishlist is empty</div>
                            <a href="{{ route('shop') }}"
                                class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                <i class="ri-shopping-cart-line mr-2"></i>
                                Start Shopping
                            </a>
                        </div>`;
                }
            }
        });

        function moveToCart(productId) {
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
                        // Remove from main wishlist page
                        const mainWishlistItem = document.getElementById(`main-wishlist-item-${productId}`);
                        if (mainWishlistItem) {
                            mainWishlistItem.remove();
                        }

                        // Update sidebar wishlist item if it exists
                        const sidebarItem = document.getElementById(`wishlist-item-${productId}`);
                        if (sidebarItem) {
                            sidebarItem.remove();
                        }

                        // Update counts
                        document.querySelectorAll('.wishlist-count').forEach(counter => {
                            counter.textContent = data.wishlist_count;
                        });
                        document.querySelectorAll('.cart-count').forEach(counter => {
                            counter.textContent = data.cart_count;
                        });

                        // Check if wishlist is empty and update the view without reload
                        if (data.wishlist_count === 0) {
                            const container = document.querySelector('.max-w-7xl');
                            container.innerHTML = `
                                <h1 class="text-2xl font-bold text-gray-800 mb-8">My Wishlist</h1>
                                <div class="text-center py-12">
                                    <div class="text-gray-500 mb-6">Your wishlist is empty</div>
                                    <a href="{{ route('shop') }}"
                                        class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                        <i class="ri-shopping-cart-line mr-2"></i>
                                        Start Shopping
                                    </a>
                                </div>`;
                        }

                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
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
                });
        }

        function moveAllToCart() {
            fetch("{{ route('wishlist.move-all-to-cart') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update counts
                        document.querySelectorAll('.wishlist-count').forEach(counter => {
                            counter.textContent = data.wishlist_count;
                        });
                        document.querySelectorAll('.cart-count').forEach(counter => {
                            counter.textContent = data.cart_count;
                        });

                        // Update the page content without reloading
                        const container = document.querySelector('.max-w-7xl');
                        container.innerHTML = `
                            <h1 class="text-2xl font-bold text-gray-800 mb-8">My Wishlist</h1>
                            <div class="text-center py-12">
                                <div class="text-gray-500 mb-6">Your wishlist is empty</div>
                                <a href="{{ route('shop') }}"
                                    class="inline-flex items-center px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                                    <i class="ri-shopping-cart-line mr-2"></i>
                                    Start Shopping
                                </a>
                            </div>`;

                        // Update sidebar if it's open
                        if (document.getElementById('wishlistSidebar') && !document.getElementById('wishlistSidebar')
                            .classList.contains('hidden')) {
                            const wishlistContent = document.getElementById('wishlistContent').querySelector(
                                '.flex-1.overflow-y-auto.p-4');
                            if (wishlistContent) {
                                wishlistContent.innerHTML =
                                    '<div class="py-8 text-center text-gray-500">Your wishlist is empty</div>';
                            }

                            const sidebarFooter = document.getElementById('wishlistContent').querySelector('.border-t');
                            if (sidebarFooter) {
                                sidebarFooter.innerHTML = `
                                <a href="{{ route('wishlist.view') }}" class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                                    View Wishlist
                                </a>`;
                            }
                        }

                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
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
                });
        }
    </script>
@endsection
