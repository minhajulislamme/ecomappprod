@extends('frontend.frontend')
@section('content')
    <!-- Facebook Pixel ViewCategory event -->
    @if (isset($pixelEvent))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                {!! $pixelEvent !!}
            });
        </script>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-4 pb-20 lg:pb-8">
        <!-- Breadcrumb -->
        <nav class=" flex  justify-between items-center mb-4">
            <div>
                <ol class="flex items-center space-x-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-orange-500">Home</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li><span class="text-orange-500">Shop</span></li>
                </ol>
            </div>
            <div class="lg:hidden ">
                <div class="flex items-center justify-start  rounded-lg p-3 ">
                    <button onclick="toggleFilter()" class="flex items-center space-x-2 text-gray-700">
                        <i class="ri-equalizer-line text-xl"></i>
                        <span>Filters</span>
                    </button>

                </div>
            </div>
        </nav>


        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Filter Sidebar -->
            <div id="filterSidebar"
                class="fixed inset-0 z-40 lg:static lg:z-0 lg:block bg-black/50 lg:bg-transparent transform translate-x-full lg:translate-x-0 transition-transform duration-300">
                <div class="w-[280px] h-full bg-white lg:w-64 lg:min-h-[calc(100vh-200px)] ml-auto lg:ml-0 overflow-y-auto">
                    <!-- Filter Header (Mobile Only) -->
                    <div class="lg:hidden flex items-center justify-between p-4 border-b">
                        <div class="flex items-center space-x-2">
                            <i class="ri-equalizer-line text-xl"></i>
                            <h3 class="font-semibold text-lg">Filters</h3>
                        </div>
                        <button onclick="toggleFilter()" class="p-2 hover:text-orange-400">
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <!-- Filter Content -->
                    <div class="p-4 space-y-6">
                        <!-- Categories Filter -->
                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Categories</h3>
                            <div class="space-y-2">
                                @foreach ($Categories as $category)
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" class="form-checkbox text-orange-400 rounded cursor-pointer">
                                        <span
                                            class="ml-2 text-gray-700 group-hover:text-orange-500">{{ $category->category_name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Price Range</h3>
                            <div class="space-y-4">
                                <div>
                                    <input type="range" class="w-full accent-orange-400" min="0" max="1000"
                                        step="10">
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <label class="text-xs text-gray-500">Min</label>
                                        <input type="number" placeholder="0"
                                            class="w-full px-3 py-1 border rounded focus:outline-none focus:border-orange-400">
                                    </div>
                                    <span class="text-gray-400">-</span>
                                    <div class="flex-1">
                                        <label class="text-xs text-gray-500">Max</label>
                                        <input type="number" placeholder="1000"
                                            class="w-full px-3 py-1 border rounded focus:outline-none focus:border-orange-400">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Colors</h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="w-8 h-8 rounded-full bg-red-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-green-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-yellow-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-purple-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-pink-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                            </div>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Colors</h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="w-8 h-8 rounded-full bg-red-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-green-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-yellow-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-purple-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-pink-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                            </div>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Colors</h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="w-8 h-8 rounded-full bg-red-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-green-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-yellow-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-purple-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-pink-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                            </div>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Colors</h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="w-8 h-8 rounded-full bg-red-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-blue-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-green-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-yellow-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-purple-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                                <button
                                    class="w-8 h-8 rounded-full bg-pink-500 ring-2 ring-offset-2 ring-transparent hover:ring-orange-400 transition-all"></button>
                            </div>
                        </div>

                        <div class="border-b pb-4">
                            <h3 class="font-semibold mb-3">Size</h3>
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">XS</button>
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">S</button>
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">M</button>
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">L</button>
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">XL</button>
                                <button
                                    class="min-w-[40px] h-10 px-2 border border-gray-300 rounded hover:border-orange-400 hover:text-orange-500 transition-all">XXL</button>
                            </div>
                        </div>

                        <!-- More filters... -->
                    </div>
                </div>
            </div>

            <!-- products Section -->
            <div class="flex-1">
                <!-- products Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                    @forelse ($products as $product)
                        <!-- product Item -->
                        <div
                            class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                            <!-- product Image -->
                            <div class="w-full aspect-square relative">
                                <!-- Add discount label only if there is a discount -->
                                @if ($product->discount_price && $product->discount_price < $product->price)
                                    @php
                                        $discountPercent = round(
                                            (($product->price - $product->discount_price) / $product->price) * 100,
                                        );
                                    @endphp
                                    <div
                                        class="absolute top-0 left-0 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-tr-lg rounded-bl-lg z-10">
                                        -{{ $discountPercent }}% OFF
                                    </div>
                                @endif
                                <div class="w-full h-full rounded-lg overflow-hidden">
                                    <a
                                        href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                        <img src="{{ asset($product->thumbnail_image) }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $product->name }}">
                                    </a>
                                </div>
                            </div>

                            <!-- Top Right Actions -->
                            <div
                                class="absolute right-2 top-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <a href="#"
                                    class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                                    <i class="ri-heart-line text-lg"></i>
                                </a>
                                <a href="#"
                                    class="p-3 bg-white rounded-full shadow-lg hover:bg-orange-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                                    <i class="ri-shopping-cart-line text-lg"></i>
                                </a>
                            </div>

                            <!-- product Info -->
                            <div class=" mt-2 text-center">
                                <h3
                                    class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate">
                                    <a
                                        href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <div class="flex items-center justify-center mb-2">
                                    <div class="flex text-yellow-400 text-sm">
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-fill"></i>
                                        <i class="ri-star-half-fill"></i>
                                    </div>
                                    <span class="text-xs text-gray-500 ml-2">(45)</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-center gap-2">
                                        @if ($product->discount_price && $product->discount_price < $product->price)
                                            <span
                                                class="text-orange-500 font-semibold">৳{{ $product->discount_price }}</span>
                                            <span class="text-gray-400 text-sm line-through">৳{{ $product->price }}</span>
                                        @else
                                            <span class="text-orange-500 font-semibold">৳{{ $product->price }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('product.details', ['id' => $product->id, 'slug' => $product->slug]) }}"
                                        class="w-full flex items-center justify-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600 transition-colors">
                                        <i class="ri-shopping-bag-line"></i>
                                        <span>Buy Now</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-10 text-center">
                            <p class="text-gray-500">No products found</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $products->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleFilter() {
            const filterSidebar = document.getElementById('filterSidebar');
            if (filterSidebar.classList.contains('translate-x-full')) {
                filterSidebar.classList.remove('translate-x-full');
            } else {
                filterSidebar.classList.add('translate-x-full');
            }
        }
    </script>
@endsection
