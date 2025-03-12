<div id="cartSidebar" class="fixed inset-0 bg-black/50 z-[100] hidden transition-opacity duration-300">
    <div id="cartContent"
        class="fixed top-0 right-0 bottom-0 w-80 md:w-96 bg-white transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden flex flex-col"
        tabindex="-1" role="dialog" aria-labelledby="cartTitle">
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-3">
                <i class="ri-shopping-cart-line text-2xl text-orange-400"></i>
                <h2 id="cartTitle" class="text-xl font-semibold">Cart (<span
                        class="cart-count">{{ count(Session::get('cart', [])) }}</span>)</h2>
            </div>
            <button class="text-gray-500 hover:text-red-500 p-2 rounded-full hover:bg-gray-100 transition-colors"
                onclick="toggleCart()" aria-label="Close cart">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Close Icon for Mobile -->
        <div class="absolute top-3 right-3 md:hidden">
            <button
                class="bg-gray-200 rounded-full p-2 text-gray-600 hover:text-red-500 hover:bg-gray-300 transition-colors"
                onclick="toggleCart()" aria-label="Close cart">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <!-- Loading State -->
        <div id="cartLoading" class="hidden flex-1 flex items-center justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-4 border-orange-500 border-t-transparent"></div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4" id="cartItems">
            @php
                $cart = Session::get('cart', []);
                $total = 0;
                foreach ($cart as $item) {
                    $price =
                        isset($item['discount_price']) && $item['discount_price'] > 0
                            ? $item['discount_price']
                            : $item['price'];
                    $total += $price * ($item['quantity'] ?? 1);
                }
            @endphp

            @if (count($cart) > 0)
                <div class="space-y-4">
                    @foreach ($cart as $cartKey => $item)
                        <div id="cart-item-{{ $cartKey }}" class="cart-item flex gap-4 border-b pb-4">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 object-cover rounded">
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="font-medium text-gray-800">{{ $item['name'] }}</h4>
                                    <button onclick="removeFromCart('{{ $cartKey }}')"
                                        class="text-gray-400 hover:text-red-500 p-1 rounded-full hover:bg-gray-100">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>

                                <div class="mt-1 text-orange-500 font-medium">
                                    ৳{{ number_format($item['price'] * ($item['quantity'] ?? 1), 2) }}</div>

                                <div class="mt-2">
                                    <div class="flex items-center border border-gray-200 rounded inline-flex">
                                        <button
                                            onclick="updateCartItemQuantity('{{ $cartKey }}', {{ ($item['quantity'] ?? 1) - 1 }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-orange-500 transition-colors">
                                            <i class="ri-subtract-line"></i>
                                        </button>
                                        <span
                                            class="quantity-value px-3 py-1 min-w-[30px] text-center">{{ $item['quantity'] ?? 1 }}</span>
                                        <button
                                            onclick="updateCartItemQuantity('{{ $cartKey }}', {{ ($item['quantity'] ?? 1) + 1 }})"
                                            class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-orange-500 transition-colors">
                                            <i class="ri-add-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center text-gray-500">Your cart is empty</div>
            @endif
        </div>

        <!-- Cart Footer - Using standard positioning like wishlist -->
        <div class="p-4 border-t bg-white">
            @if (count($cart) > 0)
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600">Subtotal:</span>
                    <span id="cart-subtotal"
                        class="font-semibold text-orange-500">৳{{ number_format($total, 2) }}</span>
                </div>
            @endif
           <!-- Wishlist Footer -->

            <a href=""
                class="w-full block py-2 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors">
                View Cart
            </a>

                <button onclick="moveAllCartToWishlist()"
                    class="w-full mt-2 py-2 px-4 border border-orange-400 text-orange-500 text-center rounded-md hover:bg-orange-50 transition-colors">
                   Proced To Checkout
                </button>


        </div>
    </div>
</div>

<script>
    function toggleCart() {
        const sidebar = document.getElementById('cartSidebar');
        const content = document.getElementById('cartContent');
        const loading = document.getElementById('cartLoading');
        const items = document.getElementById('cartItems');

        if (sidebar.classList.contains('hidden')) {
            // Open cart
            sidebar.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => content.classList.remove('translate-x-full'), 10);

            // Show loading state
            loading.classList.remove('hidden');
            items.classList.add('hidden');

            // Update content
            updateCartDrawer().finally(() => {
                loading.classList.add('hidden');
                items.classList.remove('hidden');
            });
        } else {
            // Close cart
            content.classList.add('translate-x-full');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => sidebar.classList.add('hidden'), 300);
        }
    }

    // Close cart when clicking overlay
    document.getElementById('cartSidebar').addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            toggleCart();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !document.getElementById('cartSidebar').classList.contains('hidden')) {
            toggleCart();
        }
    });

    function updateCartCounts(count) {
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count;
        });
    }

    function updateCartDrawer() {
        return fetch("{{ route('cart.get') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartItemsContainer = document.getElementById('cartContent').querySelector(
                        '.flex-1.overflow-y-auto.p-4');
                    const footerContainer = document.getElementById('cartContent').querySelector('.border-t');

                    if (cartItemsContainer) {
                        let cartHtml = '';

                        if (Object.keys(data.cart).length > 0) {
                            cartHtml += '<div class="space-y-4">';

                            Object.entries(data.cart).forEach(([cartKey, item]) => {
                                cartHtml += `
                                <div id="cart-item-${cartKey}" class="cart-item flex gap-4 border-b pb-4">
                                    <img src="${item.image}" alt="${item.name}" class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <div class="flex justify-between">
                                            <h4 class="font-medium text-gray-800">${item.name}</h4>
                                            <button onclick="removeFromCart('${cartKey}')" class="text-gray-400 hover:text-red-500 p-1 rounded-full hover:bg-gray-100">
                                                <i class="ri-close-line text-xl"></i>
                                            </button>
                                        </div>
                                        <div class="mt-1 text-orange-500 font-medium">৳${(item.price * (item.quantity || 1)).toFixed(2)}</div>
                                        <div class="mt-2">
                                            <div class="flex items-center border border-gray-200 rounded inline-flex">
                                                <button onclick="updateCartItemQuantity('${cartKey}', ${(item.quantity || 1) - 1})" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-orange-500 transition-colors">
                                                    <i class="ri-subtract-line"></i>
                                                </button>
                                                <span class="quantity-value px-3 py-1 min-w-[30px] text-center">${item.quantity || 1}</span>
                                                <button onclick="updateCartItemQuantity('${cartKey}', ${(item.quantity || 1) + 1})" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100 hover:text-orange-500 transition-colors">
                                                    <i class="ri-add-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            });

                            cartHtml += '</div>';
                        } else {
                            cartHtml = '<div class="py-8 text-center text-gray-500">Your cart is empty</div>';
                        }

                        cartItemsContainer.innerHTML = cartHtml;

                        // Update footer based on cart state
                        const footerHtml = `
                            ${Object.keys(data.cart).length > 0 ? `
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span id="cart-subtotal" class="font-semibold text-orange-500">৳${data.total.toFixed(2)}</span>
                                </div>
                            ` : ''}
                            <a href="{{ route('cart.view') }}" class="w-full block py-3 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors font-medium">
                                View Cart
                            </a>
                            ${Object.keys(data.cart).length > 0 ? `
                                <a href="#" class="w-full mt-2 py-3 px-4 border border-orange-500 text-orange-500 text-center rounded-md hover:bg-orange-50 transition-colors font-medium">
                                    Proceed to Checkout
                                </a>
                            ` : ''}
                        `;

                        footerContainer.innerHTML = footerHtml;

                        // Update cart count
                        updateCartCounts(Object.keys(data.cart).length);
                    }
                }
                return data;
            })
            .catch(error => {
                console.error('Error fetching cart:', error);
                throw error;
            });
    }

    function removeFromCart(cartKey) {
        fetch("{{ route('cart.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: cartKey
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update counts everywhere
                    updateCartCounts(data.cart_count);

                    // Remove item from sidebar
                    const sidebarItem = document.getElementById(`cart-item-${cartKey}`);
                    if (sidebarItem) {
                        sidebarItem.remove();
                    }

                    // Update main cart view if it exists
                    const mainViewItem = document.getElementById(`cart-row-${cartKey}`);
                    if (mainViewItem) {
                        mainViewItem.remove();
                    }

                    // Check if cart is empty
                    if (data.cart_count === 0) {
                        const emptyMessage = '<div class="py-8 text-center text-gray-500">Your cart is empty</div>';

                        // Update sidebar content
                        const cartContent = document.querySelector('#cartContent .flex-1.overflow-y-auto.p-4');
                        if (cartContent) {
                            cartContent.innerHTML = emptyMessage;
                        }

                        // Update footer
                        const footer = document.querySelector('#cartContent .border-t');
                        if (footer) {
                            footer.innerHTML = `
                                <a href="{{ route('cart.view') }}" class="w-full block py-3 px-4 bg-orange-500 text-white text-center rounded-md hover:bg-orange-600 transition-colors font-medium">
                                    View Cart
                                </a>
                            `;
                        }
                    }

                    // Update subtotal
                    const subtotal = document.getElementById('cart-subtotal');
                    if (subtotal) {
                        subtotal.textContent = `৳${data.total.toFixed(2)}`;
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

    function updateCartItemQuantity(cartKey, quantity) {
        if (quantity < 1) return;

        fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
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
                    // Update cart drawer with fresh content
                    updateCartDrawer();

                    // Show success notification
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Cart updated',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            })
            .catch(error => console.error('Error updating cart:', error));
    }
</script>
