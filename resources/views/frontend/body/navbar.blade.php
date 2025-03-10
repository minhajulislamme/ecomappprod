<nav class="text-orange-500 hidden lg:block">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center py-4 px-4">
            <!-- Categories Dropdown -->
            <div class="relative group">
                <button
                    class="flex items-center  justify-center space-x-2 w-[250px] bg-orange-400 text-white px-4 py-2 rounded-md mr-4 hover:text-white hover:bg-orange-600">
                    <i class="ri-menu-2-line"></i>
                    <span>Categories</span>
                    <i class="ri-arrow-down-s-line"></i>
                </button>
                <div
                    class="absolute z-10 hidden group-hover:block w-[250px] bg-white text-gray-700 shadow-lg rounded-bl-md rounded-br-md">

                    <!-- Dynamic Categories -->
                    @foreach ($Categories as $category)
                        <div class="relative group/sub py-2">
                            @php
                                $subcategories = $Subcategories->where('category_id', $category->id);
                                $hasSubcategories = !$subcategories->isEmpty();
                            @endphp
                            <div class="flex items-center justify-between px-4 py-2 hover:bg-orange-50 cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ !empty($category->category_image) ? asset($category->category_image) : 'https://placehold.co/32x32' }}"
                                        class="w-8 h-8 rounded" alt="{{ $category->category_name }}">
                                    <h3 class="font-semibold">{{ $category->category_name }}</h3>
                                </div>
                                @if ($hasSubcategories)
                                    <i class="ri-arrow-right-s-line"></i>
                                @endif
                            </div>
                            <!-- Subcategories -->
                            @if ($hasSubcategories)
                                <div
                                    class="absolute left-full top-0 hidden group-hover/sub:block w-[200px] bg-white shadow-lg rounded-md">
                                    @foreach ($subcategories as $subcategory)
                                        <a href="#"
                                            class="block px-4 py-2 hover:bg-orange-50">{{ $subcategory->subcategory_name }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>

            <!-- Main Navigation -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('home') }}"
                    class="font-semibold {{ request()->routeIs('home') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }}">
                    Home
                </a>
                <a href="#"
                    class="font-semibold {{ request()->routeIs('shop*') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }}">
                    Shop
                </a>

                <!-- Shop Dropdown -->
                <div class="relative group">
                    <button
                        class="flex font-semibold {{ request()->routeIs('shop*') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }} items-center space-x-2 py-2">
                        <span>Shop</span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>
                    <div
                        class="absolute z-10 hidden group-hover:block w-48 bg-white text-gray-700 shadow-lg rounded-md">
                        <!-- Add invisible padding to bridge the gap -->
                        <div class="h-2 -mt-2"></div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">New Arrivals</a>
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">Best Sellers</a>
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">Deals</a>
                        </div>
                    </div>
                </div>

                <!-- Pages Dropdown -->
                <div class="relative group">
                    <button
                        class="flex font-semibold {{ request()->routeIs('about*', 'contact*', 'faq*') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }} items-center space-x-2 py-2">
                        <span>Pages</span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>
                    <div
                        class="absolute z-10 hidden group-hover:block w-48 bg-white text-gray-700 shadow-lg rounded-md">
                        <div class="h-2 -mt-2"></div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">About Us</a>
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">Contact</a>
                            <a href="#" class="block px-4 py-2 hover:bg-orange-50">FAQ</a>
                        </div>
                    </div>
                </div>

                <a href="#"
                    class="font-semibold {{ request()->routeIs('blog*') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }}">
                    Blog
                </a>
                <a href="#"
                    class="font-semibold {{ request()->routeIs('contact*') ? 'text-orange-600' : 'text-gray-900 hover:text-orange-600' }}">
                    Contact
                </a>
            </div>
        </div>
    </div>
</nav>
