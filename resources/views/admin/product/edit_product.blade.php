@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white shadow-md rounded-md border border-gray-100">
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Edit Product</h2>
                    <p class="text-sm text-gray-500">Update product information</p>
                </div>
                <a href="{{ route('all.product') }}" class="btn-primary">
                    <i class="ri-file-list-line mr-1"></i>All Products
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6" id="productForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" id="category_id" required class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" required class="form-select">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->subcategory_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" required class="form-input" value="{{ $product->name }}">
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" required class="form-input" value="{{ $product->stock }}">
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" required class="form-input"
                                value="{{ $product->price }}">
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="space-y-4">
                        <div class="form-group">
                            <label>Thumbnail Image</label>
                            <input type="file" name="thumbnail_image" accept="image/*" class="form-input"
                                onchange="previewImage(this, 'thumb-preview')">
                            <img src="{{ asset($product->thumbnail_image) }}" id="thumb-preview" class="mt-2 max-h-40">
                        </div>

                        <div class="form-group">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" multiple accept="image/*" class="form-input"
                                onchange="previewMultipleImages(this, 'gallery-preview')">
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-2">
                                @if ($product->gallery_images)
                                    @foreach ($product->gallery_images as $image)
                                        <img src="{{ asset($image) }}" class="h-20 w-20 object-cover rounded">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" class="form-textarea">{{ $product->description }}</textarea>
                </div>

                <!-- Attributes -->
                @if (isset($attributes) && count($attributes) > 0)
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Product Attributes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($attributes as $attribute)
                                @php
                                    $attributeValues = json_decode($attribute->attribute_value, true) ?? [];
                                    $selectedValues = $existingAttributes[$attribute->id] ?? [];
                                @endphp

                                <div class="attribute-group p-3 border rounded" data-attribute-id="{{ $attribute->id }}">
                                    <h4 class="font-medium mb-2">{{ $attribute->attribute_name }}</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($attributeValues as $value)
                                            <label class="attribute-option">
                                                <input type="checkbox" name="attributes[{{ $attribute->id }}][]"
                                                    value="{{ $value }}"
                                                    {{ in_array($value, $selectedValues) ? 'checked' : '' }}
                                                    class="form-checkbox attribute-checkbox">
                                                @if ($attribute->attribute_type === 'color')
                                                    <span class="color-preview"
                                                        style="background-color: {{ $value }}"></span>
                                                @endif
                                                <span class="ml-2">{{ $value }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required class="form-select">
                        <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-start">
                    <button type="submit" class="btn-primary">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
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
        </script>
    @endpush

    @push('styles')
        <style>
            /* Same CSS code as add_product.blade.php */
        </style>
    @endpush
@endsection
