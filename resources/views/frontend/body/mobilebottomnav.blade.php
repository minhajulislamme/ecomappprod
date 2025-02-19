<div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg lg:hidden z-50">
    <div class="flex items-center justify-around py-3 md:py-4 max-w-3xl mx-auto">
        <a href="{{ route('home') }}"
            class="flex flex-col items-center {{ request()->routeIs('home') ? 'text-orange-400' : 'text-gray-400 hover:text-orange-400' }}">
            <i class="ri-home-4-line text-xl md:text-2xl"></i>
            <span class="text-xs md:text-sm mt-1">Home</span>
        </a>
        <a href="#"
            class="flex flex-col items-center {{ request()->routeIs('shop*') ? 'text-orange-400' : 'text-gray-400 hover:text-orange-400' }}">
            <i class="ri-store-2-line text-xl md:text-2xl"></i>
            <span class="text-xs md:text-sm mt-1">Shop</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-orange-400"
            onclick="toggleCategoryMenu(); return false;">
            <i class="ri-apps-2-line text-xl md:text-2xl"></i>
            <span class="text-xs md:text-sm mt-1">Category</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-orange-400"
            onclick="toggleCart(); return false;">
            <div class="relative">
                <i class="ri-shopping-cart-2-line text-xl md:text-2xl"></i>
                <span
                    class="cart-count absolute -top-1 -right-2 bg-orange-500 text-white text-xs md:text-sm rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center">3</span>
            </div>
            <span class="text-xs md:text-sm mt-1">Cart</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-orange-400"
            onclick="toggleWishlist(); return false;">
            <div class="relative">
                <i class="ri-heart-line text-xl md:text-2xl"></i>
                <span
                    class="wishlist-count absolute -top-1 -right-2 bg-orange-500 text-white text-xs md:text-sm rounded-full w-4 h-4 md:w-5 md:h-5 flex items-center justify-center">2</span>
            </div>
            <span class="text-xs md:text-sm mt-1">Wishlist</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400 hover:text-orange-400">
            <i class="ri-user-line text-xl md:text-2xl"></i>
            <span class="text-xs md:text-sm mt-1">Account</span>
        </a>
    </div>
</div>
