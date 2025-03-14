<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="swiper bannerSwiper rounded-lg overflow-hidden h-[200px] sm:h-[300px] md:h-[400px] lg:h-[500px]">
        <div class="swiper-wrapper">

            <!-- Swiper slides -->
            @foreach ($MainSliders as $MainSlider)
                <div class="swiper-slide">
                    <a href="{{ $MainSlider->link }}"class="block w-full h-full">
                        <img src="{{ asset($MainSlider->image) }}" class="w-full h-full object-cover object-center"
                            alt="{{ $MainSlider->title }}">
                    </a>
                </div>
            @endforeach
            {{-- <div class="swiper-slide">
                <img src="https://placeholds.co/1920x720" class="w-full h-full object-cover object-center" alt="Banner 1">
            </div>
            <div class="swiper-slide">
                <img src="https://placeholds.co/1920x720" class="w-full h-full object-cover object-center" alt="Banner 2">
            </div>
            <div class="swiper-slide">
                <img src="https://placeholds.co/1920x720" class="w-full h-full object-cover object-center" alt="Banner 3">
            </div> --}}
        </div>
        <!-- Remove navigation elements -->
    </div>
</div>
