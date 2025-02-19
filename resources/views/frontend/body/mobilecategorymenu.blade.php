<div id="mobileCategoryMenu" class="fixed inset-0 bg-black/50 bg-opacity-50 z-[100] hidden lg:hidden">
    <div id="categoryContent"
        class="fixed top-0 left-0 bottom-0 w-80 md:w-96 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Category Header -->
        <div class="flex items-center justify-between p-4 border-b border-orange-300">
            <span class="text-xl font-semibold text-orange-400">Categories</span>
            <button class="text-gray-500 hover:text-orange-400" onclick="toggleCategoryMenu()">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Category Items -->
        <div class="overflow-y-auto h-full pb-20">
            <!-- Electronics Category -->
            <div class="">
                <div class="flex items-center justify-between p-4 hover:bg-orange-50 cursor-pointer"
                    onclick="toggleSubcategory('electronics')">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded" alt="Electronics">
                        <h3 class="font-semibold">Electronics</h3>
                    </div>
                    <i class="ri-arrow-down-s-line transition-transform duration-200" id="electronics-icon"></i>
                </div>
                <div class="max-h-0 overflow-hidden transition-all duration-300 bg-gray-50" id="electronics-sub">
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Smartphones</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Laptops</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Tablets</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Accessories</a>
                </div>
            </div>

            <!-- Fashion Category -->
            <div class="">
                <div class="flex items-center justify-between p-4 hover:bg-orange-50 cursor-pointer"
                    onclick="toggleSubcategory('fashion')">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/32x32" class="w-8 h-8 rounded" alt="Fashion">
                        <h3 class="font-semibold">Fashion</h3>
                    </div>
                    <i class="ri-arrow-down-s-line transition-transform duration-200" id="fashion-icon"></i>
                </div>
                <div class="max-h-0 overflow-hidden transition-all duration-300 bg-gray-50" id="fashion-sub">
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Men's Wear</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Women's Wear</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Kids</a>
                    <a href="#" class="block px-4 py-2 pl-16 hover:bg-orange-50">Accessories</a>
                </div>
            </div>

            <!-- Add more categories with the same pattern -->
        </div>
    </div>
</div>