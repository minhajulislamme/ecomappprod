@extends('frontend.frontend')
@section('content')
    <!-- GTM Data Layer -->
    <script>
        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            ecommerce: null
        }); // Clear previous ecommerce object
        dataLayer.push({
            event: 'view_wishlist',
            ecommerce: {
                currency: 'BDT',
                value: {{ array_sum(array_map(function ($item) {return $item['discount_price'] ?? $item['price'];}, Session::get('wishlist', []))) }},
                items: Object.entries({{ json_encode(Session::get('wishlist', [])) }}).map(([id, item]) => ({
                    item_id: id,
                    item_name: item.name,
                    price: item.discount_price || item.price
                }))
            }
        });
    </script>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">My Wishlist</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="wishlist-items">
            @php
                $wishlist = Session::get('wishlist', []);
            @endphp

            @forelse($wishlist as $productId => $item)
                <div id="wishlist-grid-item-{{ $productId }}"
                    class="p-4 group relative bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                    <!-- Product Image -->
                    <div class="w-full aspect-square relative">
                        @if (isset($item['discount_price']) && $item['discount_price'] > 0 && $item['discount_price'] < $item['price'])
                            @php
                                $discountPercent = round(
                                    (($item['price'] - $item['discount_price']) / $item['price']) * 100,
                                );
                            @endphp
                            <div
                                class="absolute top-0 left-0 bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-tr-lg rounded-bl-lg z-10">
                                -{{ $discountPercent }}% OFF
                            </div>
                        @endif
                        <div class="w-full h-full rounded-lg overflow-hidden">
                            <a
                                href="{{ route('product.details', ['id' => $productId, 'slug' => Str::slug($item['name'])]) }}">
                                <img src="{{ asset($item['image']) }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $item['name'] }}">
                            </a>
                        </div>
                    </div>

                    <!-- Top Right Actions -->
                    <div
                        class="absolute right-2 top-2 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <button onclick="removeWishlistItem({{ $productId }})"
                            class="p-3 bg-white rounded-full shadow-lg hover:bg-red-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                        <button onclick="moveWishlistItemToCart({{ $productId }})"
                            class="p-3 bg-white rounded-full shadow-lg hover:bg-blue-500 hover:text-white text-gray-600 transition-all transform hover:scale-110 w-10 h-10 flex items-center justify-center">
                            <i class="ri-shopping-cart-line text-lg"></i>
                        </button>
                    </div>

                    <!-- Product Info -->
                    <div class="mt-2 text-center">
                        <h3 class="font-semibold text-gray-800 mb-1 hover:text-orange-500 transition-colors truncate">
                            <a
                                href="{{ route('product.details', ['id' => $productId, 'slug' => Str::slug($item['name'])]) }}">
                                {{ $item['name'] }}
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
                                @if (isset($item['discount_price']) && $item['discount_price'] > 0 && $item['discount_price'] < $item['price'])
                                    <span
                                        class="text-orange-500 font-semibold">৳{{ number_format($item['discount_price'], 0) }}</span>
                                    <span
                                        class="text-gray-400 text-sm line-through">৳{{ number_format($item['price'], 0) }}</span>
                                @else
                                    <span
                                        class="text-orange-500 font-semibold">৳{{ number_format($item['price'], 0) }}</span>
                                @endif
                            </div>
                            <a href="{{ route('product.details', ['id' => $productId, 'slug' => Str::slug($item['name'])]) }}"
                                class="w-full flex items-center justify-center space-x-2 bg-orange-500 text-white px-4 py-2 rounded-full text-sm hover:bg-orange-600 transition-colors">
                                <i class="ri-shopping-bag-line"></i>
                                <span>Buy Now</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-8 text-gray-500">
                    Your wishlist is empty
                </div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('wishlistItemRemoved', function(e) {
            const gridItem = document.getElementById(`wishlist-grid-item-${e.detail.productId}`);
            if (gridItem) {
                gridItem.remove();
            }

            if (e.detail.wishlistCount === 0) {
                document.getElementById('wishlist-items').innerHTML = `
                <div class="col-span-full text-center py-8 text-gray-500">
                    Your wishlist is empty
                </div>
            `;
            }
        });
    </script>
@endsection
