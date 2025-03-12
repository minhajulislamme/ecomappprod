<div class="sticky top-0 z-50 bg-white shadow-sm">
    <!-- Desktop View -->
    <div class="max-w-7xl mx-auto hidden lg:flex items-center py-2 px-4">
        <div class="flex items-center space-x-4">
            <img src="https://placehold.co/32x32" class="w-10 h-10 object-cover rounded-md" alt="">
            <a href="{{ route('home') }}" class="text-2xl text-orange-400 font-semibold">Shop Ever</a>
        </div>
        <div class="flex-1 mx-8 relative">
            <input type="text" placeholder="Search for products"
                class="w-3/4 mx-auto block border border-gray-300 bg-gray-100 rounded-md px-4 py-2 pl-10 outline-none focus:border-orange-400">
            <i class="ri-search-line absolute left-[14%] top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <div class="flex-none space-x-1">
            @auth
                <a href="{{ route('user.dashboard') }}"
                    class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50"><i class="ri-user-line"></i></a>
            @else
                <a href="{{ route('login') }}" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50"><i
                        class="ri-user-line"></i></a>
            @endauth
            <a href="#" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50 relative"
                onclick="toggleCart(); return false;">
                <i class="ri-shopping-cart-line"></i>
                <span
                    class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {{ count(Session::get('cart', [])) }}
                </span>
            </a>
            <a href="#" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50 relative"
                onclick="toggleWishlist(); return false;">
                <i class="ri-heart-line"></i>
                <span
                    class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count">
                    {{ count(Session::get('wishlist', [])) }}
                </span>
            </a>
        </div>
    </div>


</div>

<!-- Move search bar outside and make it sticky -->
<div class="sticky top-0 z-40 bg-white shadow-sm lg:hidden">
    <div class="px-4 py-2">
        <div class="relative max-w-2xl mx-auto">
            <input type="text" placeholder="Search for products"
                class="w-full block border border-gray-300 bg-gray-100 rounded-md px-4 py-2 md:py-3 pl-10 outline-none focus:border-orange-400">
            <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>
</div>
