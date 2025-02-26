@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex  justify-between mb-6">
                <div class="mb-3 sm:mb-0">
                    <div class="text-lg font-semibold">Add New Product </div>
                    <div class="text-sm font-medium text-gray-400">Add new Product to your store</div>
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
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4 sm:space-y-6" id="productForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
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
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sub Category Name</label>
                            <select id="subcategory_id" name="subcategory_id"
                                class="w-full px-4 py-2 border @error('subcategory_id') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                disabled>
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
                        {{-- price  --}}
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="text" name="price" value="{{ old('price') }}"
                                    placeholder="Enter product price"
                                    class="w-full pl-8 px-4 py-2 border @error('price') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            </div>
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Discount Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="text" name="discount_price" value="{{ old('discount_price') }}"
                                    placeholder="Enter discount price"
                                    class="w-full pl-8 px-4 py-2 border @error('discount_price') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            </div>
                            @error('discount_price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Stock</label>
                            <input type="text" name="stock" value="{{ old('stock') }}"
                                placeholder="Enter stock quantity"
                                class="w-full px-4 py-2 border @error('stock') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                            <div class="editor-container">
                                <div id="short-description-editor" class="min-h-[150px] md:min-h-[200px]"></div>
                                <input type="hidden" name="short_description" id="short-description-content"
                                    value="{{ old('short_description') }}">
                                @error('short_description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
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
                            <div class="editor-container">
                                <div id="long-description-editor" class="min-h-[150px] md:min-h-[200px]"></div>
                                <input type="hidden" name="description" id="long-description-content"
                                    value="{{ old('description') }}">
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- product status --}}
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Featured Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_featured" value="no">
                                        <input type="checkbox" name="is_featured" value="yes" class="sr-only peer"
                                            {{ old('is_featured', $product->is_featured ?? '') == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_featured', $product->is_featured ?? '') == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Trending Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_trending" value="no">
                                        <input type="checkbox" name="is_trending" value="yes" class="sr-only peer"
                                            {{ old('is_trending', $product->is_trending ?? '') == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_trending', $product->is_trending ?? '') == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Best Selling Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_best_selling" value="no">
                                        <input type="checkbox" name="is_best_selling" value="yes"
                                            class="sr-only peer"
                                            {{ old('is_best_selling', $product->is_best_selling ?? '') == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_best_selling', $product->is_best_selling ?? '') == 'yes' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Offer Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="is_offer" value="no">
                                        <input type="checkbox" name="is_offer" value="yes" class="sr-only peer"
                                            {{ old('is_offer', $product->is_offer ?? '') == 'yes' ? 'checked' : '' }}>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                    peer-focus:ring-orange-300 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                        </div>
                                        <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                            {{ old('is_offer', $product->is_offer ?? '') == 'yes' ? 'Active' : 'Inactive' }}
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
                                            <div id="upload-text-single" class="text-gray-600">
                                                <i class="fas fa-cloud-upload-alt text-sm"></i>
                                                <p class="text-xs">Drag & Drop thumbnail here</p>
                                                <p class="text-[9px] mt-1">(Max: 5MB, JPG/PNG)</p>
                                            </div>
                                            <input type="file" id="file-input-single" name="thumbnail_image"
                                                class="hidden" accept="image/jpeg,image/png"
                                                onchange="handleFile(this.files[0])">
                                            <img id="image-preview-single"
                                                class="hidden w-full h-full absolute top-0 left-0 object-cover rounded-lg p-1"
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
                                        <!-- Image previews will be inserted here -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-2 sm:pt-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include Quill JS and CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subcategorySelect = document.getElementById('subcategory_id');

            // Initialize Quill editors
            const initializeQuill = (editorId, contentInputId) => {
                const editor = document.getElementById(editorId);
                if (!editor) return null;

                const quill = new Quill(`#${editorId}`, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{
                                'header': [1, 2, 3, 4, 5, 6, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'color': []
                            }, {
                                'background': []
                            }],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'align': []
                            }],
                            ['link', 'image', 'code-block'],
                            ['clean']
                        ]
                    },
                    placeholder: 'Write your content here...'
                });

                const contentInput = document.getElementById(contentInputId);
                if (contentInput) {
                    // Load existing content if available
                    if (contentInput.value) {
                        quill.root.innerHTML = contentInput.value;
                    }

                    // Update hidden input when content changes
                    quill.on('text-change', function() {
                        // Save only the text content, not HTML
                        contentInput.value = quill.getText();
                    });
                    
                    // Ensure content is saved even if no changes were made
                    quill.root.addEventListener('blur', function() {
                        // Save only the text content, not HTML
                        contentInput.value = quill.getText();
                    });
                }

                return quill;
            };

            // Initialize both editors
            const shortDescEditor = initializeQuill('short-description-editor', 'short-description-content');
            const longDescEditor = initializeQuill('long-description-editor', 'long-description-content');

            // Make sure form captures editor content on submit
            const form = document.getElementById('productForm');
            if (form) {
                form.addEventListener('submit', function() {
                    if (shortDescEditor) {
                        document.getElementById('short-description-content').value = shortDescEditor.getText();
                    }
                    if (longDescEditor) {
                        document.getElementById('long-description-content').value = longDescEditor.getText();
                    }
                });
            }

            // Handle category change
            categorySelect.addEventListener('change', async function() {
                const categoryId = this.value;
                subcategorySelect.disabled = !categoryId;

                if (categoryId) {
                    try {
                        const response = await fetch(`/product/get-subcategories/${categoryId}`);
                        const subcategories = await response.json();

                        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>' +
                            subcategories.map(sub =>
                                `<option value="${sub.id}">${sub.subcategory_name}</option>`
                            ).join('');
                    } catch (error) {
                        console.error('Error loading subcategories:', error);
                        subcategorySelect.innerHTML =
                            '<option value="">Error loading subcategories</option>';
                    }
                } else {
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                }
            });

            // Make sure editors are responsive
            const adjustEditorHeight = () => {
                const isMobile = window.innerWidth < 768;
                const shortEditor = document.getElementById('short-description-editor');
                const longEditor = document.getElementById('long-description-editor');

                if (shortEditor) {
                    shortEditor.style.minHeight = isMobile ? '150px' : '200px';
                }

                if (longEditor) {
                    longEditor.style.minHeight = isMobile ? '150px' : '200px';
                }
            };

            // Adjust on load and resize
            adjustEditorHeight();
            window.addEventListener('resize', adjustEditorHeight);
        });
    </script>
@endpush
