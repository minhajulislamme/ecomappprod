<div class="max-w-7xl mx-auto px-4 py-2">
    <h2 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-4">New Arrivals</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        <!-- Product Item -->
        <!-- Your existing product item structure -->

        @foreach ($Products as $Product)
            <div
                class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                <!-- Product Image -->
                <div class="w-full aspect-square relative">
                    <!-- Add discount label only if there is a discount -->
                    @if ($Product->discount_price && $Product->discount_price < $Product->price)
                        @php
                            $discountPercent = round(
                                (($Product->price - $Product->discount_price) / $Product->price) * 100,
                            );
                        @endphp
                        <div
                            class="absolute top-0 left-0 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-tr-lg rounded-bl-lg z-10">
                            -{{ $discountPercent }}% OFF
                        </div>
                    @endif
                    <div class="w-full h-full rounded-lg overflow-hidden">
                        <a href="./product-details.html">
                            <img src="{{ asset($Product->thumbnail_image) }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                alt="Product">
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

                <!-- Product Info -->
                <div class=" mt-2 text-center">
                    <h3 class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate"> <a href="#">{{$Product->name}}</a> </h3>
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
                            @if ($Product->discount_price && $Product->discount_price < $Product->price)
                                <span class="text-orange-500 font-semibold">৳{{ $Product->discount_price }}</span>
                                <span class="text-gray-400 text-sm line-through">৳{{ $Product->price }}</span>
                            @else
                                <span class="text-orange-500 font-semibold">৳{{ $Product->price }}</span>
                            @endif
                        </div>
                        <a href="./product-details.html"
                            class="w-full flex items-center justify-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600 transition-colors">
                            <i class="ri-shopping-bag-line"></i>
                            <span>Buy Now</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach


    </div>


</div>
