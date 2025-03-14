<div class="max-w-7xl mx-auto px-4 py-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @foreach ($Banners as $Banner)
            <!-- First Promo Banner -->
            <a href="{{ $Banner->link }}"
                class="block rounded-lg overflow-hidden hover:opacity-95 transition-opacity shadow-md">
                <img src="{{ asset($Banner->image) }}" alt="{{ $Banner->title }}" class="w-full h-full object-cover">
            </a>
        @endforeach


        {{-- <!-- Second Promo Banner -->
        <a href="#" class="block rounded-lg overflow-hidden hover:opacity-95 transition-opacity shadow-md">
            <img src="https://placeholds.co/800x300"
                 alt="Promo Banner 2"
                 class="w-full h-full object-cover">
        </a> --}}

    </div>
</div>
