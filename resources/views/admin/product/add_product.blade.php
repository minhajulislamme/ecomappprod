@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white shadow-md rounded-md border border-gray-100">
            <!-- Header -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Add New Product</h2>
                    <p class="text-sm text-gray-500">Add new product to your store</p>
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

            <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"
                id="productForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category_id" id="category_id" required class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" required class="form-select" disabled>
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" required class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" required class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" step="0.01" name="price" required class="form-input">
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="space-y-4">
                        <div class="form-group">
                            <label>Main Image</label>
                            <input type="file" name="main_image" required accept="image/*" class="form-input"
                                onchange="previewImage(this, 'main-preview')">
                            <img id="main-preview" class="mt-2 max-h-40 hidden">
                        </div>

                        <div class="form-group">
                            <label>Thumbnail Image</label>
                            <input type="file" name="thumbnail_image" required accept="image/*" class="form-input"
                                onchange="previewImage(this, 'thumb-preview')">
                            <img id="thumb-preview" class="mt-2 max-h-40 hidden">
                        </div>

                        <div class="form-group">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" multiple accept="image/*" class="form-input"
                                onchange="previewMultipleImages(this, 'gallery-preview')">
                            <div id="gallery-preview" class="grid grid-cols-3 gap-2 mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4" class="form-textarea"></textarea>
                </div>

                <!-- Attributes -->
                @if (isset($attributes) && count($attributes) > 0)
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Product Attributes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                                    <div class="attribute-group p-3 border rounded"
                                        data-attribute-id="{{ $attribute->id }}">
                                        <h4 class="font-medium mb-2">{{ $attribute->attribute_name }}</h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($attributeValues as $value)
                                                <label class="attribute-option">
                                                    <input type="checkbox" name="attributes[{{ $attribute->id }}][]"
                                                        value="{{ $value }}"
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
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" required class="form-select">
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-start">
                    <button type="submit" class="btn-primary">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const categorySelect = document.getElementById('category_id');
                const subcategorySelect = document.getElementById('subcategory_id');

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

                // Image preview functions
                window.previewImage = function(input, previewId) {
                    const preview = document.getElementById(previewId);
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                };

                window.previewMultipleImages = function(input, previewId) {
                    const preview = document.getElementById(previewId);
                    preview.innerHTML = '';

                    if (input.files) {
                        Array.from(input.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = e => {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'h-20 w-20 object-cover rounded';
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                };

                // Add validation and debugging for attributes
                const form = document.getElementById('productForm');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get all attribute data
                    const attributeData = {};
                    document.querySelectorAll('.attribute-group').forEach(group => {
                        const attributeId = group.dataset.attributeId;
                        const checkedBoxes = group.querySelectorAll('input[type="checkbox"]:checked');
                        if (checkedBoxes.length > 0) {
                            attributeData[attributeId] = Array.from(checkedBoxes).map(cb => cb.value);
                        }
                    });

                    // Log the data that will be sent
                    console.log('Form data:', {
                        formData: new FormData(form),
                        attributes: attributeData
                    });

                    // If everything is valid, submit the form
                    form.submit();
                });

                window.validateAttribute = function(checkbox) {
                    const group = checkbox.closest('.attribute-group');
                    const groupId = group.dataset.attributeId;
                    const checkedBoxes = group.querySelectorAll('input[type="checkbox"]:checked');
                    console.log(`Attribute ${groupId} values:`, Array.from(checkedBoxes).map(cb => cb.value));
                };
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .form-group {
                @apply mb-4;
            }

            .form-group label {
                @apply block text-sm font-medium text-gray-700 mb-1;
            }

            .form-input {
                @apply w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent;
            }

            .form-select {
                @apply w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent;
            }

            .form-textarea {
                @apply w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent;
            }

            .form-checkbox {
                @apply text-orange-500 rounded border-gray-300 focus:ring-orange-500;
            }

            .btn-primary {
                @apply px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 inline-flex items-center;
            }

            .attribute-option {
                @apply flex items-center p-2 hover:bg-gray-50 rounded-md;
            }

            .color-preview {
                @apply w-6 h-6 rounded-full border border-gray-200 inline-block;
            }
        </style>
    @endpush
@endsection
