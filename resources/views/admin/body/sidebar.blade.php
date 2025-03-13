{{-- user data  --}}


<div
    class="fixed left-0 top-0 w-64 h-full bg-gray-900 p-4 z-50 sidebar-menu transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center pb-4 border-b border-b-gray-800">
        <img src="{{ !empty(Auth::user()->photo) ? url('upload/admin_images/' . Auth::user()->photo) : url('https://placehold.co/600x600') }}"
            alt="" class="w-8 h-8 rounded object-cover">
        <span class="text-lg font-bold text-white ml-3"> Admin </span>
    </a>
    <ul class="mt-4">
        <li class="mb-1 group">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-dashboard-line mr-3 text-lg"></i>
                <span class="ml-2">Dashboard</span>
            </a>
        </li>

        {{-- Products Menu --}}
        <li class="mb-1 group {{ request()->is('product*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('product*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-shopping-bag-3-line mr-3 text-lg"></i>
                <span class="ml-2">Products</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.product') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.product') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Products
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('product.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('product.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Product
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="mb-1 group {{ request()->is('category*') || request()->is('subcategory*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('category*') || request()->is('subcategory*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-file-list-3-line mr-3 text-lg"></i>
                <span class="ml-2">Category</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.category') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.category') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Category
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('category.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('category.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Category
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('all.subcategory') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.subcategory') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Subcategory
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('subcategory.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('subcategory.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Subcategory
                    </a>
                </li>
            </ul>
        </li>


        {{-- slider menu  --}}
        <li class="mb-1 group {{ request()->is('slider*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('slider*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-file-excel-2-line mr-3 text-lg"></i>
                <span class="ml-2">Slider</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.slider') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.slider') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Slider
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('slider.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('slider.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Slider
                    </a>
                </li>
            </ul>
        </li>

        {{-- banner menu  --}}
        <li class="mb-1 group {{ request()->is('banner*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('banner*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-file-copy-2-line mr-3 text-lg"></i>
                <span class="ml-2">Banner</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.banner') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.banner') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Banner
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('banner.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('banner.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Banner
                    </a>
                </li>
            </ul>
        </li>


        {{-- attribute menu  --}}
        <li class="mb-1 group {{ request()->is('attribute*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('attribute*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-article-line mr-3 text-lg"></i>
                <span class="ml-2">Attribute</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.attribute') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.attribute') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Attribute
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('attribute.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('attribute.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Attribute
                    </a>
                </li>
            </ul>
        </li>


        {{-- coupon menu  --}}
        <li class="mb-1 group {{ request()->is('coupon*') ? 'selected active' : '' }}">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md sidebar-link sidebar-dropdown-toggle {{ request()->is('coupon*') ? 'bg-gray-800 text-orange-500' : '' }}">
                <i class="ri-file-copy-2-line mr-3 text-lg"></i>
                <span class="ml-2">Coupon</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="{{ route('all.coupon') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('all.coupon') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        All Coupon
                    </a>
                </li>
                <li class="mb-4">
                    <a href="{{ route('coupon.add') }}"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 sidebar-link {{ request()->routeIs('coupon.add') ? 'text-orange-500 active' : '' }}">
                        <span class="w-1 h-1 rounded-full bg-gray-300 mr-3"></span>
                        Add Coupon
                    </a>
                </li>
            </ul>
        </li>

        <li class="mb-1 group">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-orange-500 sidebar-link sidebar-dropdown-toggle">
                <i class="ri-user-line mr-3 text-lg"></i>
                <span class="ml-2">Users</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4">
                    <a href="javascript:void()"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link active:text-orange-500">Active
                        User</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link active:text-orange-500">Inactive
                        User</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link active:text-orange-500">New
                        User</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-orange-500 sidebar-link sidebar-dropdown-toggle">
                <i class="ri-file-list-line mr-3 text-lg"></i>
                <span class="ml-2">Reports</span>
                <i class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90"></i>
            </a>
            <ul class="ml-7 mt-2 hidden group-[.selected]:block">
                <li class="mb-4 group">
                    <a href="javascript:void()"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link active:text-orange-500">Monthly
                        Report</a>
                </li>
                <li class="mb-4">
                    <a href="javascript:void()"
                        class="text-gray-300 text-sm flex items-center hover:text-orange-500 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 sidebar-link active:text-orange-500">Yearly
                        Report</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group">
            <a href="javascript:void()"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-800 hover:text-orange-500 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-orange-500 sidebar-link">
                <i class="ri-settings-2-line mr-3 text-lg"></i>
                <span class="ml-2">Settings</span>
            </a>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay hidden transition-all-smooth">
</div>
