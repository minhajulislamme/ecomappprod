
<div class="max-w-7xl mx-auto px-4 py-2">
    <h2 class="text-2xl sm:text-3xl font-semibold font-inter text-gray-800 mb-4">Top Categories</h2>
    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 gap-2">
        <!-- Category Item Template (repeat for each category) -->
        @foreach ($Categories as $Category)
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="{{ asset($Category->category_image) }}" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="{{ $Category->category_name }}">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                {{ $Category->category_name}}
            </span>
        </a>
        @endforeach

        {{-- {{ route('category.product', $Category->slug) }} --}}
       


        {{-- <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
               Man Fashion
            </span>
        </a>
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
    
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
    
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
    
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
    
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a>
        <a href="#" class="flex flex-col items-center group p-2 bg-white rounded-lg hover:shadow-md transition-all duration-300">
            <div class="w-full aspect-square rounded-lg overflow-hidden mb-1">
                <img src="https://placehold.co/200x200" 
                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-300" 
                     alt="Category">
            </div>
            <span class="font-medium text-[10px] sm:text-xs text-gray-800 group-hover:text-orange-500 text-center truncate w-full px-1">
                Category Name
            </span>
        </a> --}}
    </div>
    </div>