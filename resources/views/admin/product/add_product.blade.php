@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Add New Product</div>
                    <div class="text-sm font-medium text-gray-400">Add new product to your store</div>
                </div>
                <div class="dropdown">
                    <button type="button"
                        class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-more-2-fill"></i>
                    </button>
                    <div
                        class="dropdown-menu hidden shadow-md shadow-black/5 z-30 w-full max-w-[140px] bg-white rounded-md border border-gray-100">
                        <ul>
                            <li>
                                <a href="{{ route('all.category') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All Category</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <form id="product-form" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Producs Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Products Name</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Category Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Products Name</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- sub Category Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Products Name</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- products short description  --}}
                        <div>
                            <h3 class="text-lg font-medium mb-2">Product Short Description</h3>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <textarea name="" id="" cols="30" rows="5" placeholder="Order Notes"
                                    class="border border-gray-100 p-2.5 bg-gray-50 outline-none  rounded-md w-full text-sm focus:border-orange-500 md:col-span-2"></textarea>
                            </div>
                        </div>

                        <!-- Tags, Colors, and Sizes Grid -->

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Tags Input -->
                        <div>
                            <label for="tag-input" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <div class="relative">
                                <input id="tag-input" type="text"
                                    class="w-full h-10 px-4 pr-10 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                    placeholder="Enter tag name">
                                <button type="button" id="add-tag"
                                    class="absolute right-1 top-1/2 -translate-y-1/2 w-8 h-8 p-0 bg-orange-500 hover:bg-orange-600 text-white rounded-md transition-all duration-200 flex items-center justify-center">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <div id="tag-preview-container"
                                class="flex flex-wrap gap-2 mt-2 min-h-[40px] p-2 bg-gray-50/50 rounded-lg">
                                <!-- Tags will appear here -->
                            </div>
                        </div>

                        <!-- Colors Input -->
                        <div>
                            <label for="color-input" class="block text-sm font-medium text-gray-700 mb-2">Colors</label>
                            <div class="relative flex gap-2">
                                <div class="w-14">
                                    <input id="color-input" type="color"
                                        class="w-full h-10 border border-gray-300 rounded-lg cursor-pointer bg-white appearance-none p-0">
                                </div>
                                <div class="relative flex-1">
                                    <input type="text" id="hex-input"
                                        class="w-full h-10 px-4 pr-10 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                        placeholder="#000000" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                    <button type="button" id="add-color"
                                        class="absolute right-1 top-1/2 -translate-y-1/2 w-8 h-8 p-0 bg-orange-500 hover:bg-orange-600 text-white rounded-md transition-all duration-200 flex items-center justify-center">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="color-preview-container"
                                class="flex flex-wrap gap-2 mt-2 min-h-[40px] p-2 bg-gray-50/50 rounded-lg">
                                <!-- Colors will appear here -->
                            </div>
                        </div>

                        <!-- Sizes Input -->
                        <div>
                            <label for="size-input" class="block text-sm font-medium text-gray-700 mb-2">Sizes</label>
                            <div class="relative">
                                <input id="size-input" type="text"
                                    class="w-full h-10 px-4 pr-10 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none"
                                    placeholder="Enter size (S, M, L)">
                                <button type="button" id="add-size"
                                    class="absolute right-1 top-1/2 -translate-y-1/2 w-8 h-8 p-0 bg-orange-500 hover:bg-orange-600 text-white rounded-md transition-all duration-200 flex items-center justify-center">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                            <div id="size-preview-container"
                                class="flex flex-wrap gap-2 mt-2 min-h-[40px] p-2 bg-gray-50/50 rounded-lg">
                                <!-- Sizes will appear here -->
                            </div>
                        </div>
                    </div>
                    {{-- products description --}}
                    <div class="editor-container">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Products Descrption</label>
                        <div id="editor"></div>
                        <input type="hidden" name="content" id="content">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Products QYT</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Selling Price</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Products Discout Proce</label>
                            <input type="text" name="category_name" value="{{ old('category_name') }}"
                                placeholder="Enter category name"
                                class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('category_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>





                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Products Feature</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-orange-300 rounded-full peer 
                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900">

                                </span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Products Spacial Deals </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-orange-300 rounded-full peer 
                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900">

                                </span>
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Products Spacial offers </label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-orange-300 rounded-full peer 
                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900">

                                </span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Products host deails</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="active" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 
                                    peer-focus:ring-orange-300 rounded-full peer 
                                    peer-checked:after:translate-x-full peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px] 
                                    after:bg-white after:border-gray-300 after:border after:rounded-full 
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900">

                                </span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Products Video Link</label>
                        <input type="text" name="category_name" value="{{ old('category_name') }}"
                            placeholder="Enter category name"
                            class="w-full px-4 py-2 border @error('category_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                        @error('category_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Products Image Upload -->

                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Products Main Image</label>
                        <div class="">
                            <div class="flex justify-center md:justify-start md:mr-4 md:mb-4" id="single-image-upload">
                                <div id="drop-area-single"
                                    class="border-2 border-dashed border-gray-400 p-6 w-32 h-32 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                    ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                    ondrop="handleDrop(event)"
                                    onclick="document.getElementById('file-input-single').click()">
                                    <div id="upload-text-single" class="text-gray-600">
                                        <i class="fas fa-cloud-upload-alt text-sm mb-2"></i>
                                        <p class="text-[11px]">Drag & Drop image here or click to upload</p>
                                        <p class="text-[9px] mt-1">(Max size: 5MB, Formats: JPG, PNG)</p>
                                    </div>
                                    <input type="file" id="file-input-single" name="category_image" class="hidden"
                                        accept="image/jpeg,image/png" onchange="handleFile(this.files[0])">
                                    <img id="image-preview-single"
                                        class="hidden w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
                                        alt="Profile preview">
                                    <div id="loading-indicator"
                                        class="hidden absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500">
                                        </div>
                                    </div>
                                    @error('category_image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- multiple-image-upload  -->
                    <div id="multiple-image-upload" class="mr-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">pruducts Muliiamge Image</label>
                        <div id="drop-area-multiple"
                            class="border-2 border-dashed border-gray-400 p-6 w-32 h-32 text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                            oondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                            ondrop="handleDropMultiple(event)"
                            onclick="document.getElementById('file-input-multiple').click()">
                            <p id="upload-text-single"class=" text-xs text-gray-600">Drag &Drop image here or click to
                                upload</p>

                            <input id="file-input-multiple" type="file" class="hidden" accept="image/*" multiple
                                onchange="previewMultipleImages(event)">
                        </div>
                        <div id="image-previews"
                            class="flex flex-wrap  mt-4 rounded-md justify-center lg:justify-start mb-6">
                            <!-- Image previews will be inserted here -->
                        </div>

                    </div>



                    <!-- Submit Button -->
                    <div class="flex justify-start pt-4">
                        <button type="button" id="submit-button"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Add Product
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    
   
@endsection
