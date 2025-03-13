<div class="max-w-7xl mx-auto px-4 py-2 ">
    <div class="border border-orange-500 rounded-lg p-3">
        <!-- Flash Sales Header -->
        <div class="flex  sm:flex-row items-center justify-between gap-0 sm:gap-0 mb-6">
            <h2 class="text-2xl sm:text-3xl font-semibold text-orange-500">Flash Sales</h2>
            <div class="flex items-center gap-2">
                <span class="text-gray-600 text-sm sm:text-base">Ends in:</span>
                <div class="flex gap-1 sm:gap-2 text-white">
                    <div class="bg-orange-500 px-1 sm:px-1 py-1 rounded-md">
                        <span id="hour" class="text-base sm:text-xl font-bold">00</span>
                        <span class="text-xs">h</span>
                    </div>
                    <div class="bg-orange-500 px-1 sm:px-1 py-1 rounded-md">
                        <span id="minute" class="text-base sm:text-xl font-bold">00</span>
                        <span class="text-xs">m</span>
                    </div>
                    <div class="bg-orange-500 px-1 sm:px-1 py-1 rounded-md">
                        <span id="second" class="text-base sm:text-xl font-bold">00</span>
                        <span class="text-xs">s</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Sales Slider -->
        <div class="relative">
            <div class="swiper flashSalesSwiper">
                <div class="swiper-wrapper">

                    <!-- Your existing product items wrapped in swiper-slide -->
                    @foreach ($Products as $Product)
                        @if ($Product->is_offer == 'yes')
                            <div class="swiper-slide">
                                <!-- Your existing product item structure -->
                                <div
                                    class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                                    <!-- Product Image -->
                                    <div class="w-full aspect-square relative">
                                        <!-- Add discount label only if there is a discount -->
                                        @if ($Product->discount_price && $Product->discount_price < $Product->price)
                                            @php
                                                $discountPercent = round(
                                                    (($Product->price - $Product->discount_price) / $Product->price) *
                                                        100,
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
                                        <h3
                                            class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate">
                                            <a href="#">{{ $Product->name }}</a>
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
                                                @if ($Product->discount_price && $Product->discount_price < $Product->price)
                                                    <span
                                                        class="text-orange-500 font-semibold">৳{{ $Product->discount_price }}</span>
                                                    <span
                                                        class="text-gray-400 text-sm line-through">৳{{ $Product->price }}</span>
                                                @else
                                                    <span
                                                        class="text-orange-500 font-semibold">৳{{ $Product->price }}</span>
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

                            </div>
                            <!-- Add more swiper-slide divs for other products -->
                        @endif
                    @endforeach



                </div>
            </div>

        </div>
    </div>
</div>


<script>
    // Get end time from database
    const endTime = new Date("{{ $flashSaleTimer->end_time }}").getTime();

    // Update the countdown every 1 second
    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = endTime - now;

        // Calculate total hours, minutes and seconds
        const totalHours = Math.floor(distance / (1000 * 60 * 60));
        const minute = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const second = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result with leading zeros
        document.getElementById("hour").innerHTML = totalHours.toString().padStart(2, '0');
        document.getElementById("minute").innerHTML = minute.toString().padStart(2, '0');
        document.getElementById("second").innerHTML = second.toString().padStart(2, '0');

        // If the countdown is finished, clear the interval
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("hour").innerHTML = "00";
            document.getElementById("minute").innerHTML = "00";
            document.getElementById("second").innerHTML = "00";
        }
    }, 1000);
</script>
