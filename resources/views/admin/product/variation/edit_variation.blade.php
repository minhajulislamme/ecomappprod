@extends('admin.admin_dashboard')

@section('admin_content')
    <!-- Add Quill CSS in head with custom styles -->


    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex  justify-between mb-6">
                <div class="mb-3 sm:mb-0">
                    <div class="text-lg font-semibold">Add New Product Variation </div>
                    <div class="text-sm font-medium text-gray-400">Add new Product Variation to your store</div>
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
                                <a href="{{ route('admin.products.variations.index', $product->id) }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All Variation</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div>
                <form action="{{ route('admin.products.variations.update', [$product->id, $variation->id]) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6" id="productForm">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">



                        {{-- price  --}}
                        <div class="w-full">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Price</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="price" value="{{ old('price', $variation->price) }}"
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
                                    value="{{ old('discount_price', $variation->discount_price) }}"
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
                            <input type="number" name="stock" value="{{ old('stock', $variation->stock) }}"
                                placeholder="Enter stock quantity" min="0"
                                class="w-full px-4 py-2 border @error('stock') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            @error('stock')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Replace status field with hidden input --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3"> Status</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="status" value="inactive">
                                <input type="checkbox" name="status" value="active" class="sr-only peer"
                                    {{ old('status', $variation->status) == 'active' ? 'checked' : '' }}>
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                            peer-focus:ring-orange-300 rounded-full peer
                            peer-checked:after:translate-x-full peer-checked:after:border-white
                            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:border-gray-300 after:border after:rounded-full
                            after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                    {{ old('status', $variation->status) == 'active' ? 'Active' : 'Inactive' }}
                                </span>
                            </label>
                        </div>

                        <!-- Replace the attributes section -->
                        <div class="col-span-1 md:col-span-2 border rounded-lg p-3 sm:p-5 bg-gray-50">
                            <h3 class="text-base sm:text-lg font-semibold mb-3 sm:mb-4 flex items-center">
                                <i class="ri-list-settings-line mr-2 text-orange-500"></i>
                                Product Attributes
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                @foreach ($attributesWithValues as $attribute)
                                    <div
                                        class="attribute-group p-3 sm:p-4 border rounded bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <h4 class="font-medium mb-2 sm:mb-3 pb-1 sm:pb-2 border-b text-gray-700">
                                            {{ $attribute['name'] }}
                                        </h4>
                                        <div class="flex flex-wrap gap-2 sm:gap-3">
                                            @if ($attribute['type'] === 'color')
                                                @foreach ($attribute['values'] as $value)
                                                    <label class="attribute-option flex items-center cursor-pointer group">
                                                        <input type="radio"
                                                            name="attribute_values[{{ $attribute['name'] }}]"
                                                            value="{{ $value }}"
                                                            class="form-radio h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500 transition duration-150"
                                                            {{ old('attribute_values.' . $attribute['name'], $attribute['selected'] ?? '') == $value ? 'checked' : '' }}>
                                                        <span
                                                            class="color-preview inline-block w-5 h-5 rounded-full ml-2 border border-gray-200"
                                                            style="background-color: {{ $value }}"></span>
                                                        <span
                                                            class="ml-2 text-sm text-gray-700 group-hover:text-orange-600 transition-colors duration-150">
                                                            {{ $value }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            @else
                                                @foreach ($attribute['values'] as $value)
                                                    <label class="attribute-option flex items-center cursor-pointer group">
                                                        <input type="radio"
                                                            name="attribute_values[{{ $attribute['name'] }}]"
                                                            value="{{ $value }}"
                                                            class="form-radio h-4 w-4 text-orange-600 border-gray-300 focus:ring-orange-500 transition duration-150"
                                                            {{ old('attribute_values.' . $attribute['name'], $attribute['selected'] ?? '') == $value ? 'checked' : '' }}>
                                                        <span
                                                            class="ml-2 text-sm text-gray-700 group-hover:text-orange-600 transition-colors duration-150">
                                                            {{ $value }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
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
                                            <input type="file" id="file-input-single" name="variation_image"
                                                class="hidden" accept="image/jpeg,image/png"
                                                onchange="handleFile(this.files[0])">
                                            <img id="image-preview-single" src="{{ asset($variation->variation_image) }}"
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
                                            @error('variation_image')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-2 sm:pt-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Update Product variation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            /* Only keep form-group styles if needed elsewhere */
            .form-group {
                @apply mb-4;
            }

            .form-group label {
                @apply block text-sm font-medium text-gray-700 mb-1;
            }

            .attribute-group {
                @apply transition-all duration-200;
            }

            .attribute-group:hover {
                @apply shadow-md;
            }

            .form-checkbox:checked {
                @apply bg-orange-500 border-orange-500;
            }

            .form-checkbox:checked:hover {
                @apply bg-orange-600 border-orange-600;
            }

            .form-checkbox:focus {
                @apply ring-2 ring-orange-500 ring-opacity-50;
            }

            /* Update the radio button styles */
            .form-radio {
                @apply rounded-full;
            }

            .form-radio:checked {
                @apply bg-orange-500 border-orange-500;
            }

            .form-radio:checked:hover {
                @apply bg-orange-600 border-orange-600;
            }

            .form-radio:focus {
                @apply ring-2 ring-orange-500 ring-opacity-50;
            }

            .attribute-group {
                @apply transition-all duration-200;
            }

            .attribute-group:hover {
                @apply shadow-md;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Form validation
            document.getElementById('productForm').addEventListener('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                this.classList.add('was-validated');
            });

            // Image preview with validation
            function handleFile(file) {
                const preview = document.getElementById('image-preview-single');
                const loadingIndicator = document.getElementById('loading-indicator');
                const uploadText = document.getElementById('upload-text-single');

                if (file) {
                    // Validate file size
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        return;
                    }

                    loadingIndicator.classList.remove('hidden');
                    uploadText.classList.add('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            if (this.width < 400 || this.height < 400) {
                                alert('Image dimensions must be at least 400x400 pixels');
                                loadingIndicator.classList.add('hidden');
                                uploadText.classList.remove('hidden');
                                preview.classList.add('hidden');
                                return;
                            }
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                            loadingIndicator.classList.add('hidden');
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Color selection functionality
            document.addEventListener('DOMContentLoaded', function() {
                const colorRadios = document.querySelectorAll('.color-radio');

                colorRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const colorOption = this.closest('.color-option');
                        const colorValue = colorOption.dataset.value;
                        const attributeGroup = colorOption.closest('.mb-4');
                        const previewSection = attributeGroup.querySelector('.selected-color-preview');
                        const colorName = previewSection.querySelector('.selected-color-name');
                        const colorBox = previewSection.querySelector('.selected-color-box');

                        colorName.textContent = colorValue;
                        colorBox.style.backgroundColor = colorValue;
                        previewSection.classList.remove('hidden');
                    });

                    // Show initial selection
                    if (radio.checked) {
                        radio.dispatchEvent(new Event('change'));
                    }
                });
            });

            // Drag and drop functionality
            function handleDragOver(event) {
                event.preventDefault();
                event.currentTarget.classList.add('border-orange-500');
            }

            function handleDragLeave(event) {
                event.currentTarget.classList.remove('border-orange-500');
            }

            function handleDrop(event) {
                event.preventDefault();
                event.currentTarget.classList.remove('border-orange-500');
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    handleFile(file);
                }
            }

            // Add this to your existing scripts
            document.addEventListener('DOMContentLoaded', function() {
                const attributeGroups = document.querySelectorAll('.attribute-group');

                attributeGroups.forEach(group => {
                    const radioInputs = group.querySelectorAll('input[type="radio"]');

                    radioInputs.forEach(radio => {
                        radio.addEventListener('change', function() {
                            // Uncheck all other radio buttons in other attribute groups
                            radioInputs.forEach(otherRadio => {
                                if (otherRadio !== radio && otherRadio.checked) {
                                    otherRadio.checked = false;
                                }
                            });
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
