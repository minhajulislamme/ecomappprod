<div id="wishlistSidebar" class="fixed inset-0 bg-black/50 z-[100] hidden">
    <div id="wishlistContent"
        class="fixed top-0 right-0 bottom-0 w-80 md:w-96 bg-white transform translate-x-full transition-transform duration-300 ease-in-out overflow-hidden flex flex-col">
        <!-- Wishlist Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <div class="flex items-center space-x-3">
                <i class="ri-heart-line text-2xl text-orange-400"></i>
                <span class="text-xl font-semibold">Wishlist (<span class="wishlist-count">2</span>)</span>
            </div>
            <button class="text-gray-500 hover:text-orange-400" onclick="toggleWishlist()">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Wishlist Items -->
        <div class="flex-1 overflow-y-auto p-4">
            <!-- Wishlist items content -->
            <div id="wishlist-item-1" class="wishlist-item flex items-center space-x-4 border-b pb-4 mb-4">
                <img src="https://placehold.co/80x80" class="w-20 h-20 object-cover rounded-md" alt="Product">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Product Name</h3>
                    <p class="text-orange-500 font-medium mt-1">$99.00</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button onclick="moveToCart(1)"
                            class="text-xs bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-gray-400 hover:text-red-500" onclick="removeFromWishlist(1)">
                        <i class="ri-delete-bin-line text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Wishlist Item -->
            <div id="wishlist-item-2" class="wishlist-item flex items-center space-x-4 border-b pb-4 mb-4">
                <img src="https://placehold.co/80x80" class="w-20 h-20 object-cover rounded-md" alt="Product">
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">Product Name</h3>
                    <p class="text-orange-500 font-medium mt-1">$159.00</p>
                    <div class="flex items-center space-x-2 mt-2">
                        <button onclick="moveToCart(2)"
                            class="text-xs bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <div class="text-right">
                    <button class="text-gray-400 hover:text-red-500" onclick="removeFromWishlist(2)">
                        <i class="ri-delete-bin-line text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Wishlist Footer -->
        <div class="border-t p-4 bg-white">
            <button onclick="moveAllToCart()"
                class="w-full bg-orange-500 text-white text-center px-4 py-2.5 rounded-md hover:bg-orange-600 transition-colors font-medium">
                Add All to Cart
            </button>
        </div>
    </div>
</div>