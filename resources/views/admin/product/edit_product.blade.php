@extends('admin.admin_dashboard')

@section('admin_content')
    <!-- Add Quill CSS in head with custom styles -->
    @push('styles')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .ql-toolbar.ql-snow {
                border: 1px solid #e5e7eb;
                border-top-left-radius: 0.5rem;
                border-top-right-radius: 0.5rem;
                background-color: #f9fafb;
                padding: 0.75rem;
            }

            .ql-container.ql-snow {
                border: 1px solid #e5e7eb;
                border-bottom-left-radius: 0.5rem;
                border-bottom-right-radius: 0.5rem;
                border-top: none;
                font-family: inherit;
                font-size: 0.875rem;
                min-height: 200px;
            }

            .ql-editor {
                padding: 1rem;
                min-height: 200px;
            }

            .ql-editor p {
                margin-bottom: 0.5rem;
            }

            .ql-snow .ql-toolbar button,
            .ql-snow.ql-toolbar button {
                padding: 4px 6px;
            }

            .ql-snow .ql-tooltip {
                border-radius: 0.375rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 0.5rem;
            }

            .ql-snow .ql-picker {
                font-size: 0.875rem;
            }

            .ql-editor:focus {
                border-color: #f97316;
                box-shadow: 0 0 0 1px #f97316;
            }

            /* Style toolbar buttons on hover */
            .ql-snow.ql-toolbar button:hover,
            .ql-snow .ql-toolbar button:hover,
            .ql-snow.ql-toolbar button.ql-active,
            .ql-snow .ql-toolbar button.ql-active,
            .ql-snow.ql-toolbar .ql-picker-label:hover,
            .ql-snow .ql-toolbar .ql-picker-label:hover,
            .ql-snow.ql-toolbar .ql-picker-label.ql-active,
            .ql-snow .ql-toolbar .ql-picker-label.ql-active,
            .ql-snow.ql-toolbar .ql-picker-item:hover,
            .ql-snow .ql-toolbar .ql-picker-item:hover,
            .ql-snow.ql-toolbar .ql-picker-item.ql-selected,
            .ql-snow .ql-toolbar .ql-picker-item.ql-selected {
                color: #f97316;
            }

            .ql-snow.ql-toolbar button:hover .ql-fill,
            .ql-snow .ql-toolbar button:hover .ql-fill,
            .ql-snow.ql-toolbar button.ql-active .ql-fill,
            .ql-snow .ql-toolbar button.ql-active .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-label:hover .ql-fill,
            .ql-snow .ql-toolbar .ql-picker-label:hover .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-item:hover .ql-fill,
            .ql-snow .ql-toolbar .ql-picker-item:hover .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-fill,
            .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-fill,
            .ql-snow.ql-toolbar button:hover .ql-stroke,
            .ql-snow .ql-toolbar button:hover .ql-stroke,
            .ql-snow.ql-toolbar button.ql-active .ql-stroke,
            .ql-snow .ql-toolbar button.ql-active .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-label:hover .ql-stroke,
            .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-label.ql-active .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-item:hover .ql-stroke,
            .ql-snow .ql-toolbar .ql-picker-item:hover .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke,
            .ql-snow.ql-toolbar .ql-picker-item.ql-selected .ql-stroke {
                stroke: #f97316 !important;
            }

            /* Custom placeholder styling */
            .ql-editor.ql-blank::before {
                font-style: normal;
                color: #9ca3af;
            }

            /* Editor wrapper styling */
            .editor-wrapper {
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
                margin-bottom: 1rem;
            }
        </style>
    @endpush

    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div class="mb-3 sm:mb-0">
                    <div class="text-lg font-semibold">Edit Product</div>
                    <div class="text-sm font-medium text-gray-400">Update existing product details</div>
                </div>
                <div class="dropdown self-start sm:self-center">
                    <button type="button"
                        class="dropdown-toggle text-gray-400 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                        <i class="ri-more-2-fill"></i>
                    </button>
                    <div
                        class="dropdown-menu hidden shadow-md shadow-black/5 z-30 w-full max-w-[140px] bg-white rounded-md border border-gray-100">
                        <ul>
                            <li>
                                <a href="{{ route('all.product') }}"
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
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4 sm:space-y-6" id="productForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                placeholder="Enter product name"
                                class="w-full px-4 py-2 border @error('name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category Dropdown -->
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                            <select id="category_id" name="category_id"
                                class="w-full px-4 py-2 border @error('category_id') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- sub category  --}}
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub Category Name (Optional)</label>
                            <select id="subcategory_id" name="subcategory_id"
                                class="w-full px-4 py-2 border @error('subcategory_id') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->subcategory_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <script>
                            document.getElementById('subcategory_id').addEventListener('change', function() {
                                // Ensure empty string is sent when "Select Subcategory" is chosen
                                if (!this.value) {
                                    this.value = '';
                                }
                            });
                        </script>

                        {{-- price  --}}
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    placeholder="Enter product price" min="0" step="0.01"
                                    class="w-full pl-8 px-4 py-2 border @error('price') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Discount Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="discount_price"
                                    value="{{ old('discount_price', $product->discount_price) }}"
                                    placeholder="Enter discount price" min="0" step="0.01"
                                    class="w-full pl-8 px-4 py-2 border @error('discount_price') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                            </div>
                            @error('discount_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Stock</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                placeholder="Enter stock quantity" min="0"
                                class="w-full px-4 py-2 border @error('stock') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                            <div class="editor-wrapper">
                                <div id="short_description_editor"></div>
                            </div>
                            <input type="hidden" name="short_description" id="short_description_input"
                                value="{{ old('short_description', $product->short_description) }}">
                            @error('short_description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attributes Section -->
                        @if (isset($attributes) && count($attributes) > 0)
                            <div class="col-span-1 md:col-span-2 border rounded-lg p-3 sm:p-5 bg-gray-50">
                                <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                                    <i class="ri-list-settings-line mr-2 text-orange-500"></i>
                                    Product Attributes
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                    @foreach ($attributes as $attribute)
                                        @php
                                            // Safely decode JSON and ensure we have an array
                                            $attributeValues = [];
                                            try {
                                                $decoded = json_decode($attribute->attribute_value, true);
                                                $attributeValues = is_array($decoded) ? $decoded : [];
                                            } catch (\Exception $e) {
                                                $attributeValues = [];
                                            }
                                        @endphp

                                        @if (!empty($attributeValues))
                                            <div class="attribute-group p-3 sm:p-4 border rounded bg-white shadow-sm hover:shadow-md transition-shadow duration-200"
                                                data-attribute-id="{{ $attribute->id }}">
                                                <h4 class="font-medium mb-2 sm:mb-3 pb-1 sm:pb-2 border-b text-gray-700">
                                                    {{ $attribute->attribute_name }}</h4>
                                                <div class="flex flex-wrap gap-2 sm:gap-3">
                                                    @foreach ($attributeValues as $value)
                                                        <label
                                                            class="attribute-option flex items-center cursor-pointer group">
                                                            <input type="checkbox"
                                                                name="attributes[{{ $attribute->id }}][]"
                                                                value="{{ $value }}"
                                                                class="form-checkbox h-4 w-4 text-orange-600 rounded border-gray-300 focus:ring-orange-500 transition duration-150">
                                                            @if ($attribute->attribute_type === 'color')
                                                                <span
                                                                    class="color-preview inline-block w-5 h-5 rounded-full ml-2 border border-gray-200"
                                                                    style="background-color: {{ $value }}"></span>
                                                            @endif
                                                            <span
                                                                class="ml-2 text-sm text-gray-700 group-hover:text-orange-600 transition-colors duration-150">{{ $value }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- long description --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <div class="editor-wrapper">
                                <div id="description_editor"></div>
                            </div>
                            <input type="hidden" name="description" id="description_input"
                                value="{{ old('description', $product->description) }}">
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Video URL</label>
                            <input type="text" name="product_video" value="{{ old('discount_price', $product->product_video) }}"
                                placeholder="Enter product video URL"
                                class="w-full px-4 py-2 border @error('product_video') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('product_video')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- product status --}}
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Featured Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_featured" value="no">
                                        <input type="checkbox" name="is_featured" value="yes" class="sr-only peer"
                                            {{ old('is_featured', $product->is_featured) == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_featured', $product->is_featured) == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Trending Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_trending" value="no">
                                        <input type="checkbox" name="is_trending" value="yes" class="sr-only peer"
                                            {{ old('is_trending', $product->is_trending) == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_trending', $product->is_trending) == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Best Selling Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_best_selling" value="no">
                                        <input type="checkbox" name="is_best_selling" value="yes"
                                            class="sr-only peer"
                                            {{ old('is_best_selling', $product->is_best_selling) == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_best_selling', $product->is_best_selling) == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Offer Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_offer" value="no">
                                        <input type="checkbox" name="is_offer" value="yes" class="sr-only peer"
                                            {{ old('is_offer', $product->is_offer) == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_offer', $product->is_offer) == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3"> Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="status" value="inactive">
                                        <input type="checkbox" name="status" value="active" class="sr-only peer"
                                            {{ old('status', $product->status) == 'active' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('status', $product->status) == 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Product Images Section -->
                        <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- Thumbnail Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product Thumbnail</label>
                                <div class="w-full">
                                    <div class="flex justify-center" id="single-image-upload">
                                        <div id="drop-area-single"
                                            class="border-2 border-dashed border-gray-400 p-3 w-full aspect-square max-w-xs text-center rounded-lg cursor-pointer hover:border-orange-500 relative"
                                            ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                            ondrop="handleDrop(event)"
                                            onclick="document.getElementById('file-input-single').click()">
                                            <div id="upload-text-single"
                                                class="text-gray-600 {{ $product->thumbnail_image ? 'hidden' : '' }}">
                                                <i class="fas fa-cloud-upload-alt text-sm"></i>
                                                <p class="text-xs">Drag & Drop thumbnail here</p>
                                                <p class="text-[9px] mt-1">(Max: 5MB, JPG/PNG)</p>
                                            </div>
                                            <input type="file" id="file-input-single" name="thumbnail_image"
                                                class="hidden" accept="image/jpeg,image/png"
                                                onchange="handleFile(this.files[0])">
                                            <img id="image-preview-single"
                                                class="{{ $product->thumbnail_image ? 'block' : 'hidden' }} w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
                                                src="{{ $product->thumbnail_image ? asset($product->thumbnail_image) : '' }}"
                                                alt="Thumbnail preview">
                                            <div id="loading-indicator"
                                                class="hidden absolute inset-0 bg-white bg-opacity-80">
                                                <div
                                                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                    <div
                                                        class="animate-spin rounded-full h-5 w-5 border-b-2 border-orange-500">
                                                    </div>
                                                </div>
                                            </div>
                                            @error('thumbnail_image')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Gallery Images Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product Gallery</label>
                                <div id="multiple-image-upload" class="w-full">
                                    <div id="drop-area-multiple"
                                        class="border-2 border-dashed border-gray-400 p-3 w-32 aspect-square max-w-xs text-center rounded-lg cursor-pointer hover:border-orange-500 relative transition-colors duration-200"
                                        ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
                                        ondrop="handleDropMultiple(event)"
                                        onclick="document.getElementById('file-input-multiple').click()">
                                        <div class="text-gray-600 py-2">
                                            <i class="fas fa-images text-sm"></i>
                                            <p class="text-xs">Drag & Drop gallery images</p>
                                            <p class="text-[9px] mt-1">(Max: 5MB each, JPG/PNG)</p>
                                        </div>
                                        <input id="file-input-multiple" type="file" name="gallery_images[]"
                                            class="hidden" accept="image/jpeg,image/png" multiple
                                            onchange="previewMultipleImages(event)">
                                    </div>
                                    <div id="image-previews" class="flex flex-wrap gap-2 mt-3 rounded-md">
                                        @if (!empty($product->gallery_images))
                                            @foreach ($product->gallery_images as $index => $image)
                                                <div class="existing-preview relative">
                                                    <img src="{{ asset($image) }}"
                                                        alt="Gallery image {{ $index + 1 }}"
                                                        class="w-24 h-24 object-cover rounded border border-gray-200">
                                                    <span
                                                        class="existing-image-remove absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer"
                                                        onclick="removeExistingImage(this)"
                                                        data-index="{{ $index }}">×</span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-2 sm:pt-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Quill JS before closing body -->
    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const commonConfig = {
                    theme: 'snow',
                    modules: {
                        toolbar: {
                            container: [
                                [{
                                    'header': [1, 2, 3, false]
                                }],
                                ['bold', 'italic', 'underline', 'strike'],
                                [{
                                    'color': []
                                }, {
                                    'background': []
                                }],
                                [{
                                    'align': []
                                }],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                ['link'],
                                ['clean']
                            ]
                        }
                    },
                    bounds: document.body,
                    scrollingContainer: 'html'
                };

                // Initialize Short Description Quill with custom config
                const shortDescriptionQuill = new Quill('#short_description_editor', {
                    ...commonConfig,
                    placeholder: 'Enter a brief product description...'
                });

                // Initialize Description Quill with custom config
                const descriptionQuill = new Quill('#description_editor', {
                    ...commonConfig,
                    placeholder: 'Enter detailed product description...'
                });

                // Set initial content if exists
                const shortDescriptionContent = document.getElementById('short_description_input').value;
                if (shortDescriptionContent) {
                    shortDescriptionQuill.root.innerHTML = shortDescriptionContent;
                }

                const descriptionContent = document.getElementById('description_input').value;
                if (descriptionContent) {
                    descriptionQuill.root.innerHTML = descriptionContent;
                }

                // Function to handle editor focus states
                function handleEditorFocus(editor, wrapper) {
                    editor.on('selection-change', function(range) {
                        if (range) {
                            wrapper.classList.add('focused');
                        } else {
                            wrapper.classList.remove('focused');
                        }
                    });
                }

                // Add focus handling to both editors
                handleEditorFocus(shortDescriptionQuill, shortDescriptionQuill.container.closest('.editor-wrapper'));
                handleEditorFocus(descriptionQuill, descriptionQuill.container.closest('.editor-wrapper'));

                // Update hidden inputs before form submission
                document.getElementById('productForm').addEventListener('submit', function() {
                    document.getElementById('short_description_input').value = shortDescriptionQuill.root
                        .innerHTML;
                    document.getElementById('description_input').value = descriptionQuill.root.innerHTML;
                });

                // Make sure editors are responsive
                const adjustEditorHeight = () => {
                    const isMobile = window.innerWidth < 768;

                    if (isMobile) {
                        shortDescriptionQuill.container.style.height = '200px';
                        descriptionQuill.container.style.height = '300px';
                    } else {
                        shortDescriptionQuill.container.style.height = '200px';
                        descriptionQuill.container.style.height = '400px';
                    }
                };

                // Adjust on load and resize
                adjustEditorHeight();
                window.addEventListener('resize', adjustEditorHeight);

                // Keep track of removed gallery images
                window.removedGalleryImages = [];

                // Function to remove existing gallery images
                window.removeExistingImage = function(element) {
                    const index = element.getAttribute('data-index');
                    window.removedGalleryImages.push(index);

                    // Create a hidden input to track removed images
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_gallery_images[]';
                    input.value = index;
                    document.getElementById('productForm').appendChild(input);

                    // Remove the preview element
                    element.parentElement.remove();
                };

                // Handle image preview functionality
                window.handleFile = function(file) {
                    if (!file) return;

                    const maxSize = 5 * 1024 * 1024; // 5MB
                    const validTypes = ['image/jpeg', 'image/png'];
                    const preview = document.getElementById('image-preview-single');
                    const textElement = document.getElementById('upload-text-single');
                    const loadingIndicator = document.getElementById('loading-indicator');

                    if (file.size > maxSize) {
                        alert('File size exceeds 5MB limit');
                        return;
                    }

                    if (!validTypes.includes(file.type)) {
                        alert('Please select a valid image file (JPG or PNG)');
                        return;
                    }

                    textElement.classList.add('hidden');
                    loadingIndicator.classList.remove('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        loadingIndicator.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                };

                // Handle multiple image preview
                window.previewMultipleImages = function(event) {
                    const files = event.target.files;
                    const previewContainer = document.getElementById('image-previews');
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    const validTypes = ['image/jpeg', 'image/png'];

                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            alert(`File "${files[i].name}" exceeds 5MB limit`);
                            continue;
                        }

                        if (!validTypes.includes(files[i].type)) {
                            alert(`File "${files[i].name}" is not a valid image type`);
                            continue;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'preview relative';
                            div.innerHTML = `
                        <img src="${e.target.result}" class="w-24 h-24 object-cover rounded border border-gray-200" />
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center cursor-pointer" onclick="this.parentElement.remove()">×</span>
                    `;
                            previewContainer.appendChild(div);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                };

                // Handle drag and drop
                window.handleDragOver = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.currentTarget.classList.add('border-orange-500');
                };

                window.handleDragLeave = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.currentTarget.classList.remove('border-orange-500');
                };

                window.handleDrop = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.currentTarget.classList.remove('border-orange-500');
                    if (e.dataTransfer.files.length > 0) {
                        handleFile(e.dataTransfer.files[0]);
                    }
                };

                window.handleDropMultiple = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.currentTarget.classList.remove('border-orange-500');
                    if (e.dataTransfer.files.length > 0) {
                        document.getElementById('file-input-multiple').files = e.dataTransfer.files;
                        previewMultipleImages({
                            target: {
                                files: e.dataTransfer.files
                            }
                        });
                    }
                };

                // Handle category change
                const categorySelect = document.getElementById('category_id');
                const subcategorySelect = document.getElementById('subcategory_id');

                categorySelect.addEventListener('change', async function() {
                    const categoryId = this.value;

                    // Reset subcategory select
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory (Optional)</option>';
                    subcategorySelect.disabled = !categoryId;

                    if (categoryId) {
                        try {
                            const response = await fetch(`/product/get-subcategories/${categoryId}`);
                            const subcategories = await response.json();

                            if (subcategories.length > 0) {
                                subcategories.forEach(sub => {
                                    const option = document.createElement('option');
                                    option.value = sub.id;
                                    option.textContent = sub.subcategory_name;
                                    subcategorySelect.appendChild(option);
                                });
                            }
                        } catch (error) {
                            console.error('Error loading subcategories:', error);
                        }
                    }
                });

                // Check if a subcategory should be selected based on the product data
                if (categorySelect.value) {
                    const productSubcategoryId = '{{ $product->subcategory_id ?? '' }}';
                    if (productSubcategoryId) {
                        setTimeout(() => {
                            const options = subcategorySelect.querySelectorAll('option');
                            for (let option of options) {
                                if (option.value == productSubcategoryId) {
                                    option.selected = true;
                                    break;
                                }
                            }
                        }, 100);
                    }
                }

                // Check the correct attributes based on existing product data
                const existingAttributes = @json($existingAttributes ?? []);
                if (existingAttributes) {
                    for (const attributeId in existingAttributes) {
                        const values = existingAttributes[attributeId];
                        const checkboxes = document.querySelectorAll(`input[name="attributes[${attributeId}][]"]`);

                        checkboxes.forEach(checkbox => {
                            if (values.includes(checkbox.value)) {
                                checkbox.checked = true;
                            }
                        });
                    }
                }
            });
        </script>
    @endpush
@endsection
