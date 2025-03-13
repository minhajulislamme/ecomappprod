@php
    $Categories = \App\Models\Category::where('status', 'active')->orderBy('category_name', 'asc')->get();
    $Subcategories = \App\Models\SubCategory::where('status', 'active')->orderBy('subcategory_name', 'asc')->get();

@endphp


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
            <!-- Dynamic Categories -->
            @foreach ($Categories as $category)
                @php
                    $subcategories = $Subcategories->where('category_id', $category->id);
                    $hasSubcategories = !$subcategories->isEmpty();
                    $categoryId = 'category-' . $category->id;
                @endphp
                <div class="">
                    <div class="flex items-center justify-between p-4 hover:bg-orange-50 cursor-pointer"
                        @if ($hasSubcategories) onclick="toggleSubcategory('{{ $categoryId }}')" @endif>
                        <a href="{{ route('product.category', ['id' => $category->id, 'slug' => $category->category_slug]) }}"
                            class="flex items-center space-x-3 flex-grow">
                            <img src="{{ !empty($category->category_image) ? asset($category->category_image) : 'https://placehold.co/32x32' }}"
                                class="w-8 h-8 rounded" alt="{{ $category->category_name }}">
                            <h3 class="font-semibold">{{ $category->category_name }}</h3>
                        </a>
                        @if ($hasSubcategories)
                            <i class="ri-arrow-down-s-line transition-transform duration-200"
                                id="{{ $categoryId }}-icon"></i>
                        @endif
                    </div>
                    @if ($hasSubcategories)
                        <div class="max-h-0 overflow-hidden transition-all duration-300 bg-gray-50"
                            id="{{ $categoryId }}-sub">
                            @foreach ($subcategories as $subcategory)
                                <a href="{{ route('product.subcategory', ['id' => $subcategory->id, 'slug' => $subcategory->subcategory_slug]) }}"
                                    class="block px-4 py-2 pl-16 hover:bg-orange-50">{{ $subcategory->subcategory_name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
