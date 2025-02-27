@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="bg-white shadow-md rounded-md border border-gray-100 p-6">
            <!-- Header -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Add New Variation</h2>
                    <p class="text-sm text-gray-500">Create a new variation for {{ $product->name }}</p>
                </div>
                <a href="{{ route('admin.products.variations.index', $product->id) }}" class="btn-primary">
                    <i class="ri-arrow-left-line mr-1"></i>Back to Variations
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

            <form action="{{ route('admin.products.variations.store', $product->id) }}" method="POST"
                enctype="multipart/form-data" id="variation-form" class="needs-validation" novalidate>
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <!-- Removed SKU input field -->

                        <div class="form-group">
                            <label for="price">Price <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">$</span>
                                <input type="number" id="price" step="0.01" min="0" max="999999.99"
                                    name="price" value="{{ old('price') }}" required class="form-input pl-8">
                            </div>
                            @error('price')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sale Price (Optional)</label>
                            <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" required class="form-input">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Images and Attributes -->
                    <div class="space-y-4">
                        <div class="form-group">
                            <label for="image">Variation Image <span class="text-red-500">*</span></label>
                            <div class="mt-2">
                                <input type="file" id="image" name="variation_image" accept="image/*"
                                    class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                    file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700
                                    hover:file:bg-orange-100"
                                    required onchange="previewImage(this)">
                                <p class="text-sm text-gray-500 mt-1">
                                    Minimum 400x400px, Maximum 5MB. Supported formats: JPG, PNG, WebP
                                </p>
                            </div>
                            <div class="mt-2">
                                <img id="image-preview"
                                    class="hidden max-w-[200px] max-h-[200px] object-contain rounded border">
                            </div>
                            @error('image')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="block font-medium mb-2">Attributes</label>
                            @foreach ($attributesWithValues as $attribute)
                                <div class="mb-4 p-3 border rounded">
                                    <label class="block font-medium mb-2">{{ $attribute['name'] }} <span
                                            class="text-gray-500 text-sm">(Optional)</span></label>
                                    @if ($attribute['type'] === 'color')
                                        <div class="grid grid-cols-6 gap-2">
                                            @foreach ($attribute['values'] as $value)
                                                <label class="color-option" data-value="{{ $value }}">
                                                    <input type="radio" name="attribute_values[{{ $attribute['name'] }}]"
                                                        value="{{ $value }}" class="sr-only color-radio"
                                                        {{ old('attribute_values.' . $attribute['name']) == $value ? 'checked' : '' }}>
                                                    <div class="color-swatch-wrapper" title="{{ $value }}">
                                                        <div class="color-preview"
                                                            style="background-color: {{ $value }}">
                                                            <div class="color-name">{{ $value }}</div>
                                                        </div>
                                                        <span class="color-check">
                                                            <i class="ri-check-line"></i>
                                                        </span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="mt-2">
                                            <div class="selected-color-preview hidden">
                                                Selected color: <span class="font-medium selected-color-name"></span>
                                                <div class="selected-color-box mt-1"></div>
                                            </div>
                                        </div>
                                    @else
                                        <select name="attribute_values[{{ $attribute['name'] }}]" class="form-select">
                                            <option value="">Select {{ $attribute['name'] }} (Optional)</option>
                                            @foreach ($attribute['values'] as $value)
                                                <option value="{{ $value }}"
                                                    {{ old('attribute_values.' . $attribute['name']) == $value ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('attribute_values.' . $attribute['name'])
                                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                        @enderror
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end space-x-3">
                    <button type="button" onclick="history.back()" class="btn-secondary">
                        <i class="ri-arrow-left-line mr-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="ri-save-line mr-1"></i>Create Variation
                    </button>
                </div>
            </form>
        </div>
    </div>

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

            .btn-primary {
                @apply px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 inline-flex items-center;
            }

            .btn-secondary {
                @apply px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 inline-flex items-center;
            }

            .color-option {
                @apply relative inline-block cursor-pointer transition-transform duration-200;
            }

            .color-option:hover {
                transform: scale(1.1);
            }

            .color-swatch-wrapper {
                @apply relative w-12 h-12 rounded-lg border-2 border-transparent transition-all duration-200;
            }

            .color-preview {
                @apply absolute inset-0 rounded-lg border border-gray-200 overflow-hidden;
            }

            .color-name {
                @apply absolute inset-x-0 bottom-0 text-xs py-1 px-1 text-center bg-black bg-opacity-50 text-white opacity-0 transition-opacity duration-200;
            }

            .color-option:hover .color-name {
                @apply opacity-100;
            }

            .color-check {
                @apply absolute inset-0 flex items-center justify-center text-white opacity-0 transition-opacity duration-200;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
            }

            .color-option input:checked+.color-swatch-wrapper {
                @apply border-orange-500 ring-2 ring-orange-500 ring-offset-2;
            }

            .color-option input:checked+.color-swatch-wrapper .color-check {
                @apply opacity-100;
            }

            .selected-color-preview {
                @apply p-3 border rounded-md;
            }

            .selected-color-box {
                @apply w-full h-12 rounded-md border border-gray-200;
            }

            /* Light color adjustments */
            .color-option[data-value="#ffffff"] .color-check,
            .color-option[data-value="#f8f8f8"] .color-check,
            .color-option[data-value="#f0f0f0"] .color-check,
            .color-option[data-value="#e0e0e0"] .color-check {
                @apply text-gray-800;
                text-shadow: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Enhanced form validation
            document.getElementById('variation-form').addEventListener('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                this.classList.add('was-validated');
            });

            // Enhanced image preview with validation
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const file = input.files[0];

                if (file) {
                    // Validate file size
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        input.value = '';
                        preview.classList.add('hidden');
                        return;
                    }

                    // Create preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');

                        // Validate dimensions
                        const img = new Image();
                        img.onload = function() {
                            if (this.width < 400 || this.height < 400) {
                                alert('Image dimensions must be at least 400x400 pixels');
                                input.value = '';
                                preview.classList.add('hidden');
                            }
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Validate hex color
            function isValidColor(color) {
                // Check for hex color format
                if (/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(color)) {
                    return true;
                }
                // Check for rgb format
                if (/^rgb\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*\)$/.test(color)) {
                    return true;
                }
                return false;
            }

            // Convert RGB to Hex
            function rgbToHex(rgb) {
                const match = rgb.match(/^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/);
                if (match) {
                    const [_, r, g, b] = match;
                    return `#${(1 << 24 | (r << 16) | (g << 8) | b).toString(16).slice(1)}`;
                }
                return null;
            }

            // Format color value
            function formatColorValue(color) {
                if (color.startsWith('rgb')) {
                    return rgbToHex(color) || color;
                }
                return color;
            }

            // Color preview functionality with validation
            document.addEventListener('DOMContentLoaded', function() {
                const colorRadios = document.querySelectorAll('.color-radio');
                const form = document.querySelector('form');

                colorRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const colorOption = this.closest('.color-option');
                        const colorValue = colorOption.dataset.value;
                        const attributeGroup = colorOption.closest('.mb-4');
                        const previewSection = attributeGroup.querySelector('.selected-color-preview');
                        const colorName = previewSection.querySelector('.selected-color-name');
                        const colorBox = previewSection.querySelector('.selected-color-box');
                        const errorDiv = attributeGroup.querySelector('.color-error') ||
                            document.createElement('div');

                        // Validate color
                        if (!isValidColor(colorValue)) {
                            errorDiv.className = 'text-red-500 text-sm mt-1 color-error';
                            errorDiv.textContent = 'Invalid color format';
                            if (!attributeGroup.querySelector('.color-error')) {
                                attributeGroup.appendChild(errorDiv);
                            }
                            return;
                        } else {
                            if (attributeGroup.querySelector('.color-error')) {
                                attributeGroup.querySelector('.color-error').remove();
                            }
                        }

                        const formattedColor = formatColorValue(colorValue);
                        colorName.textContent = formattedColor;
                        colorBox.style.backgroundColor = formattedColor;
                        previewSection.classList.remove('hidden');

                        // Update the radio button value with formatted color
                        this.value = formattedColor;
                    });

                    // Show initial selection
                    if (radio.checked) {
                        radio.dispatchEvent(new Event('change'));
                    }
                });

                // Form validation
                form.addEventListener('submit', function(e) {
                    const colorRadios = document.querySelectorAll('.color-radio:checked');
                    let hasError = false;

                    colorRadios.forEach(radio => {
                        const colorValue = radio.value;
                        if (!isValidColor(colorValue)) {
                            hasError = true;
                            const attributeGroup = radio.closest('.mb-4');
                            const errorDiv = attributeGroup.querySelector('.color-error') ||
                                document.createElement('div');
                            errorDiv.className = 'text-red-500 text-sm mt-1 color-error';
                            errorDiv.textContent = 'Please select a valid color';
                            if (!attributeGroup.querySelector('.color-error')) {
                                attributeGroup.appendChild(errorDiv);
                            }
                        }
                    });

                    if (hasError) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    @endpush
@endsection
