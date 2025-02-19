<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Ever Store</title>
    <!-- rimix icon cdn  -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Add Swiper CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- CSS -->
    @vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.js'])
</head>

<body class="bg-gray-100 font-jost">
    <!-- top bar start  -->
    <div class="sticky top-0 z-50 bg-white shadow-sm">
        <!-- Desktop View -->
        <div class="max-w-7xl mx-auto hidden lg:flex items-center py-2 px-4">
            <div class="flex items-center space-x-4">
                <img src="https://placehold.co/32x32" class="w-10 h-10 rounded-md" alt="">
                <a href="#" class="text-2xl text-orange-400 font-semibold">Shop Ever</a>
            </div>
            <div class="flex-1 mx-8 relative">
                <input type="text" placeholder="Search for products"
                    class="w-3/4 mx-auto block border border-gray-300 bg-gray-100 rounded-md px-4 py-2 pl-10 outline-none focus:border-orange-400">
                <i class="ri-search-line absolute left-[14%] top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
            <div class="flex-none space-x-1">
                <a href="#" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50"><i
                        class="ri-user-line"></i></a>
                <a href="#" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50 relative"
                    onclick="toggleCart(); return false;">
                    <i class="ri-shopping-cart-line"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </a>
                <a href="#" class="text-1xl text-orange-400 p-2 rounded-sm hover:bg-orange-50 relative"
                    onclick="toggleWishlist(); return false;">
                    <i class="ri-heart-line"></i>
                    <span
                        class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center wishlist-count">2</span>
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
    <!-- Mobile/Tablet View -->
    <div class="lg:hidden">
        <!-- Mobile Header -->
        <div class="flex items-center justify-between p-4">
            <div class="flex items-center space-x-3">
                <img src="https://placehold.co/32x32" class="w-8 h-8 md:w-10 md:h-10 rounded-md" alt="">
                <a href="#" class="text-xl md:text-2xl text-orange-400 font-semibold">Shop Ever</a>
            </div>
            <a href="#" class="text-gray-500 hover:text-orange-400" onclick="toggleMenu()">
                <i class="ri-menu-line text-2xl md:text-3xl"></i>
            </a>
        </div>
    </div>
    <!-- Mobile Side Menu -->
    <div id="mobileMenu" class="fixed inset-0 bg-black/50 bg-opacity-50 z-50 hidden lg:hidden">
        <div id="menuContent"
            class="fixed top-0 left-0 bottom-0 w-80 md:w-96 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out">
            <!-- Menu Header -->
            <div class="flex items-center justify-between p-4 md:p-6 border-b border-orange-300">
                <div class="flex items-center space-x-3">
                    <img src="https://placehold.co/32x32" class="w-8 h-8 md:w-10 md:h-10 rounded-md" alt="">
                    <span class="text-xl md:text-2xl font-semibold text-orange-400">Shop Ever</span>
                </div>
                <a href="#" class="text-gray-500 hover:text-orange-400" onclick="toggleMenu()">
                    <i class="ri-close-line text-2xl md:text-3xl"></i>
                </a>
            </div>

            <!-- Menu Items -->
            <div class="py-4 md:py-6">
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">Home</a>
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">New
                    Arrivals</a>
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">Best
                    Sellers</a>
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">Deals</a>
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">Blog</a>
                <a href="#"
                    class="block px-4 md:px-6 py-2 md:py-3 text-gray-800 hover:bg-orange-50 hover:text-orange-600 cursor-pointer text-base md:text-lg">Contact</a>
            </div>

            <!-- Menu Footer -->
            <div class="absolute bottom-0 left-0 right-0 border-t p-4 md:p-6">
                <div class="flex items-center space-x-3 text-base md:text-lg">
                    <i class="ri-user-line text-orange-400 text-xl md:text-2xl"></i>
                    <span>Login / Register</span>
                </div>
            </div>
        </div>
    </div>

    <!-- top bar end  -->

    <!-- Navbar start  -->
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
                        <!-- Electronics Category -->
                        <div class="relative group/sub py-2">
                            <div class="flex items-center justify-between px-4 py-2 hover:bg-orange-50 cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <img src="https://placehold.co/32x32" class="w-8 h-8 rounded" alt="Electronics">
                                    <h3 class="font-semibold">Electronics</h3>
                                </div>
                                <i class="ri-arrow-right-s-line"></i>
                            </div>
                            <!-- Subcategories -->
                            <div
                                class="absolute left-full top-0 hidden group-hover/sub:block w-[200px] bg-white shadow-lg rounded-md">
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Smartphones</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Laptops</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Tablets</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Accessories</a>
                            </div>
                        </div>

                        <!-- Fashion Category -->
                        <div class="relative group/sub py-2">
                            <div class="flex items-center justify-between px-4 py-2 hover:bg-orange-50 cursor-pointer">
                                <div class="flex items-center space-x-3">
                                    <img src="https://placehold.co/32x32" class="w-8 h-8 rounded" alt="Fashion">
                                    <h3 class="font-semibold">Fashion</h3>
                                </div>
                                <i class="ri-arrow-right-s-line"></i>
                            </div>
                            <!-- Subcategories -->
                            <div
                                class="absolute left-full top-0 hidden group-hover/sub:block w-[200px] bg-white shadow-lg rounded-md">
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Men's Wear</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Women's Wear</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Kids</a>
                                <a href="#" class="block px-4 py-2 hover:bg-orange-50">Accessories</a>
                            </div>
                        </div>

                        <!-- Add more categories here with the same pattern -->
                    </div>
                </div>

                <!-- Main Navigation -->
                <div class="flex items-center space-x-6">
                    <a href="#" class=" font-semibold text-gray-900 hover:text-orange-600">Home</a>
                    <a href="#" class=" font-semibold text-gray-900 hover:text-orange-600">Home</a>

                    <!-- Shop Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex font-semibold text-gray-900 items-center space-x-2 hover:text-orange-600 py-2">
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
                            class="flex font-semibold text-gray-900 items-center space-x-2 hover:text-orange-600 py-2">
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

                    <a href="#" class="font-semibold text-gray-900 hover:text-orange-600">Blog</a>
                    <a href="#" class="font-semibold text-gray-900 hover:text-orange-600">Contact</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar end  -->

    <!-- Mobile Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg lg:hidden z-50">
        <div class="flex items-center justify-around py-3 md:py-4 max-w-3xl mx-auto">
            <a href="./index.html" class="flex flex-col items-center text-orange-400">
                <i class="ri-home-4-line text-xl md:text-2xl"></i>
                <span class="text-xs md:text-sm mt-1">Home</span>
            </a>
            <a href="./shop.html" class="flex flex-col items-center text-gray-400 hover:text-orange-400">
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

    <!-- Mobile Category Menu -->
    <div id="mobileCategoryMenu" class="fixed inset-0 bg-black/50 bg-opacity-50 z-50 hidden lg:hidden">
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

    <!-- Main Content -->

    @yield('content')
    <!-- show more product  end  -->
    <!-- Scroll to top button -->
    <a href="#" id="scrollToTop"
        class="fixed bottom-20 right-4 lg:bottom-8 lg:right-8 bg-orange-500 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center transform scale-0 transition-all duration-300 hover:bg-orange-600 z-50">
        <i class="ri-arrow-up-line text-xl"></i>
    </a>

    <!-- delivery trust secure payment start -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Free Delivery -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-truck-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Free Delivery</h3>
                    <p class="text-gray-500 text-sm">Free shipping on all orders over $200</p>
                </div>
            </div>

            <!-- Money Back Guarantee -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-money-dollar-circle-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Money Back Guarantee</h3>
                    <p class="text-gray-500 text-sm">100% money back guarantee</p>
                </div>
            </div>

            <!-- Secure Payment -->
            <div
                class="flex items-center space-x-6 p-6 rounded-lg  transition-all duration-300 group border-2 border-dashed border-orange-200">
                <div
                    class="w-16 h-16 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                    <i class="ri-shield-check-line text-3xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">Secure Payment</h3>
                    <p class="text-gray-500 text-sm">All payments are secured</p>
                </div>
            </div>
        </div>
    </div>
    <!-- delivery trust secure payment end -->

    <!-- Floating Action Buttons -->
    <div class="fixed left-4 bottom-20 lg:bottom-8 z-50">
        <!-- Main Chat Button -->
        <a href="#" onclick="toggleFloatingButtons()"
            class="relative flex items-center justify-center w-10 h-10 bg-orange-500 text-white rounded-full shadow-lg hover:bg-orange-600 transform hover:-translate-y-1 transition-all duration-300 group">
            <i class="ri-message-3-line text-xl"></i>
            <span
                class="absolute left-full ml-2 bg-orange-500 text-white text-sm py-1 px-2 rounded whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                Live Chat
            </span>
        </a>

        <!-- Hidden Buttons Container -->
        <div id="hiddenButtons"
            class="absolute bottom-16 left-0 flex flex-col gap-3 scale-0 opacity-0 transition-all duration-300 origin-bottom-left">
            <!-- massenger  -->
            <a href="https://m.me/username" target="_blank" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-messenger-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Messenger</span>
            </a>
            <!-- WhatsApp -->
            <a href="https://wa.me/1234567890" target="_blank" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-green-500 text-white rounded-full shadow-lg hover:bg-green-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-whatsapp-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">WhatsApp</span>
            </a>

            <!-- Call -->
            <a href="tel:+1234567890" class="flex items-center group">
                <div
                    class="flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transform hover:-translate-y-1 transition-all duration-300">
                    <i class="ri-phone-line text-2xl"></i>
                </div>
                <span
                    class="bg-orange-500 text-white text-sm py-1 px-2 rounded ml-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Call
                    Us</span>
            </a>
        </div>
    </div>


    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="fixed inset-0 bg-black/50 z-50 hidden">
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

    <!-- Wishlist Sidebar -->
    <div id="wishlistSidebar" class="fixed inset-0 bg-black/50 z-50 hidden">
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

    <!-- Footer Section -->
    <footer class="bg-gray-900 mt-8 pt-8 pb-16 lg:pb-8 text-gray-300">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Footer Top -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="https://placehold.co/32x32" alt="Logo" class="w-8 h-8 rounded">
                        <span class="text-xl font-semibold text-orange-400">Shop Ever</span>
                    </div>
                    <p class="text-gray-400 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                        eiusmod tempor incididunt ut labore.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="ri-facebook-fill text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="ri-twitter-fill text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="ri-instagram-fill text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-orange-400 transition-colors">
                            <i class="ri-youtube-fill text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">About Us</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Contact Us</a>
                        </li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Products</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Login</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Sign Up</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2">
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Payment
                                Methods</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Money-back
                                Guarantee!</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Returns</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Shipping</a></li>
                        <li><a href="#"
                                class="text-gray-400 hover:text-orange-400 transition-colors text-sm">Terms and
                                conditions</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Contact Info</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start space-x-3 text-gray-400 text-sm">
                            <i class="ri-map-pin-2-line mt-1"></i>
                            <span>123 Street Name, City, Country</span>
                        </li>
                        <li class="flex items-center space-x-3 text-gray-400 text-sm">
                            <i class="ri-phone-line"></i>
                            <span>+123 456 7890</span>
                        </li>
                        <li class="flex items-center space-x-3 text-gray-400 text-sm">
                            <i class="ri-mail-line"></i>
                            <span>info@example.com</span>
                        </li>
                        <li class="flex items-center space-x-3 text-gray-400 text-sm">
                            <i class="ri-time-line"></i>
                            <span>Mon-Sat 9:00am-5:00pm</span>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-white font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-400 text-sm mb-4">Subscribe to our newsletter and get 10% off your first
                        purchase</p>
                    <form class="space-y-2">
                        <input type="email" placeholder="Your email address"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:border-orange-400 text-gray-300 text-sm placeholder-gray-500">
                        <a href="#"
                            class="w-full bg-orange-400 text-white px-4 py-2 rounded-md hover:bg-orange-500 transition-colors text-sm flex items-center justify-center">
                            Subscribe
                        </a>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="mt-8 pt-8 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <!-- Copyright -->
                    <div class="text-gray-400 text-sm">
                        © 2024 <span class="text-orange-400">Shop Ever</span>. All rights reserved.
                    </div>
                    <!-- Payment Methods -->
                    <div class="flex items-center space-x-4">
                        <img src="https://placehold.co/40x25" alt="Visa" class="h-6">
                        <img src="https://placehold.co/40x25" alt="Mastercard" class="h-6">
                        <img src="https://placehold.co/40x25" alt="PayPal" class="h-6">
                        <img src="https://placehold.co/40x25" alt="American Express" class="h-6">
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Add padding to body to prevent content from being hidden behind fixed bottom nav -->


    <!-- JS -->
    {{-- <script src="src/js/app.js"></script> --}}

    <script src={{ asset('js/frontend/custom.js') }}></script>
    <style>

    </style>
</body>

</html>

</html>
