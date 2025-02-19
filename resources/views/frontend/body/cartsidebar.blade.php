<div id="cartSidebar" class="fixed inset-0 bg-black/50 z-[100] hidden">
    <div id="cartContent"
        class="fixed top-0 right-0 bottom-0 w-80 md:w-96 bg-white transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden flex flex-col">
        <!-- Cart Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-3">
                <i class="ri-shopping-cart-2-line text-2xl text-orange-400"></i>
                <span class="text-xl font-semibold">Shopping Cart (<span class="cart-count">3</span>)</span>
            </div>
            <button class="text-gray-500 hover:text-orange-400" onclick="toggleCart()">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4">
            <!-- Cart items content -->
            <div id="cart-item-1" class="cart-item flex items-center space-x-4 border-b pb-4 mb-4"
                data-base-price="99.00">
                <img src="https://placehold.co/80x80" class="w-20 h-20 object-cover rounded-md" alt="Product">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Product Name</h3>
                    <p class="text-gray-600 text-sm">Size: M, Color: Blue</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button
                            class="w-6 h-6 bg-gray-100 rounded-md flex items-center justify-center hover:bg-gray-200"
                            onclick="decrementQuantity(1)">-</button>
                        <span class="text-gray-800 quantity-value">1</span>
                        <button
                            class="w-6 h-6 bg-gray-100 rounded-md flex items-center justify-center hover:bg-gray-200"
                            onclick="incrementQuantity(1)">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-orange-400 item-price">$99.00</p>
                    <button class="text-gray-400 hover:text-red-500 mt-2" onclick="removeCartItem(1)">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>

            <!-- Cart Item -->
            <div id="cart-item-2" class="cart-item flex items-center space-x-4 border-b pb-4 mb-4"
                data-base-price="159.00">
                <img src="https://placehold.co/80x80" class="w-20 h-20 object-cover rounded-md" alt="Product">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Product Name</h3>
                    <p class="text-gray-600 text-sm">Size: L, Color: Red</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button
                            class="w-6 h-6 bg-gray-100 rounded-md flex items-center justify-center hover:bg-gray-200"
                            onclick="decrementQuantity(2)">-</button>
                        <span class="text-gray-800 quantity-value">1</span>
                        <button
                            class="w-6 h-6 bg-gray-100 rounded-md flex items-center justify-center hover:bg-gray-200"
                            onclick="incrementQuantity(2)">+</button>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold text-orange-400 item-price">$159.00</p>
                    <button class="text-gray-400 hover:text-red-500 mt-2" onclick="removeCartItem(2)">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Footer -->
        <div class="border-t p-4 bg-white">
            <div class="space-y-3 mb-4">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal:</span>
                    <span class="text-gray-800" id="cart-subtotal">$258.00</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Shipping:</span>
                    <span class="text-gray-800">Free</span>
                </div>
                <div class="flex justify-between pt-2 border-t">
                    <span class="font-semibold text-gray-800">Total:</span>
                    <div class="text-right">
                        <span class="font-semibold text-gray-800" id="cart-total">$258.00</span>
                        <p class="text-xs text-gray-500">Including VAT</p>
                    </div>
                </div>
            </div>
            <div class="space-y-2">
                <a href="/checkout"
                    class="block w-full bg-orange-500 text-white text-center px-4 py-2.5 rounded-md hover:bg-orange-600 transition-colors font-medium">
                    Proceed to Checkout
                </a>
                <a href="/cart"
                    class="block w-full bg-gray-100 text-gray-800 text-center px-4 py-2.5 rounded-md hover:bg-gray-200 transition-colors font-medium">
                    View Cart
                </a>
            </div>
        </div>
    </div>
</div>