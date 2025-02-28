@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Edit Attribute</div>
                    <div class="text-sm font-medium text-gray-400">Modify attribute and its values</div>
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
                                <a href="{{ route('all.attribute') }}"
                                    class="py-2 px-4 text-[13px] flex items-center hover:bg-gray-50 group">
                                    <i class="ri-file-list-line text-gray-400 mr-3"></i>
                                    <span class="text-gray-600 group-hover:text-orange-500 font-medium">All
                                        Attributes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div>
                <form action="{{ route('attribute.update', $attribute->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Attribute Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Name</label>
                            <input type="text" name="attribute_name" value="{{ $attribute->attribute_name }}"
                                placeholder="Enter attribute name (e.g. Color, Size)"
                                class="w-full px-4 py-2 border @error('attribute_name') border-red-500 @enderror border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                            @error('attribute_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Attribute Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Type</label>
                            <select name="attribute_type" id="attribute_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                                <option value="text" {{ $attribute->attribute_type === 'text' ? 'selected' : '' }}>Text
                                </option>
                                <option value="color" {{ $attribute->attribute_type === 'color' ? 'selected' : '' }}>Color
                                </option>
                                <option value="number" {{ $attribute->attribute_type === 'number' ? 'selected' : '' }}>
                                    Number
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Attribute Values -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Values</label>
                        <div id="values-container" class="flex flex-wrap gap-2">
                            @foreach (json_decode($attribute->attribute_value) as $value)
                                <div class="flex gap-2 w-full sm:w-auto">
                                    <div class="flex gap-2 items-center value-input-group w-full sm:w-auto">
                                        <input type="{{ $attribute->attribute_type === 'number' ? 'number' : 'text' }}"
                                            name="attribute_values[]" required value="{{ $value }}"
                                            class="w-full sm:w-32 px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition value-input"
                                            placeholder="{{ $attribute->attribute_type === 'color' ? 'Enter color name' : ($attribute->attribute_type === 'number' ? 'Enter numeric value' : 'Enter value') }}">
                                        <input type="color" value="{{ $value }}"
                                            class="color-picker {{ $attribute->attribute_type !== 'color' ? 'hidden' : '' }} h-9 w-14 cursor-pointer"
                                            onchange="updateColorValue(this)">
                                        <button type="button"
                                            class="remove-value px-2 py-1 text-sm bg-red-500 text-white rounded-md">-</button>
                                        <button type="button"
                                            class="add-value px-2 py-1 text-sm bg-green-500 text-white rounded-md">+</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Attribute Status</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="status" value="inactive">
                            <input type="checkbox" name="status" value="active" class="sr-only peer"
                                {{ old('status', $attribute->status) == 'active' ? 'checked' : '' }}>
                            <div
                                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4
                                peer-focus:ring-orange-300 rounded-full peer
                                peer-checked:after:translate-x-full peer-checked:after:border-white
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 status-text">
                                {{ old('status', $attribute->status) == 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Update Attribute
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('values-container');
            const attributeType = document.getElementById('attribute_type');
            const savedValues = {!! json_encode(json_decode($attribute->attribute_value)) !!};

            function toggleColorPickers() {
                const isColor = attributeType.value === 'color';
                const isNumber = attributeType.value === 'number';

                document.querySelectorAll('.color-picker').forEach(picker => {
                    picker.classList.toggle('hidden', !isColor);
                });

                document.querySelectorAll('.value-input').forEach(input => {
                    if (isColor) {
                        input.setAttribute('placeholder', 'Enter color name');
                        input.setAttribute('type', 'text');
                    } else if (isNumber) {
                        input.setAttribute('placeholder', 'Enter numeric value');
                        input.setAttribute('type', 'number');
                        input.setAttribute('step', 'any'); // Allow decimal numbers
                    } else {
                        input.setAttribute('placeholder', 'Enter value');
                        input.setAttribute('type', 'text');
                    }
                });
            }

            function createValueInput(value = '') {
                const isColor = attributeType.value === 'color';
                const isNumber = attributeType.value === 'number';
                const placeholder = isColor ? 'Enter color name' : (isNumber ? 'Enter numeric value' :
                    'Enter value');
                const inputType = isNumber ? 'number' : 'text';
                const stepAttr = isNumber ? 'step="any"' : '';

                const newRow = document.createElement('div');
                newRow.className = 'flex gap-2 w-full sm:w-auto';
                newRow.innerHTML = `
                <div class="flex gap-2 items-center value-input-group w-full sm:w-auto">
                    <input type="${inputType}" name="attribute_values[]" required value="${value}"
                        class="w-full sm:w-32 px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition value-input"
                        placeholder="${placeholder}" ${stepAttr}>
                    <input type="color" class="color-picker ${!isColor ? 'hidden' : ''} h-9 w-14 cursor-pointer"
                        onchange="updateColorValue(this)" ${isColor && value ? `value="${value}"` : ''}>
                    <button type="button" class="remove-value px-2 py-1 text-sm bg-red-500 text-white rounded-md">-</button>
                    <button type="button" class="add-value px-2 py-1 text-sm bg-green-500 text-white rounded-md">+</button>
                </div>
            `;
                return newRow;
            }

            // Initialize with saved values
            container.innerHTML = '';
            savedValues.forEach(value => {
                container.appendChild(createValueInput(value));
            });

            attributeType.addEventListener('change', toggleColorPickers);

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-value')) {
                    container.appendChild(createValueInput());
                }

                if (e.target.classList.contains('remove-value')) {
                    const rows = container.querySelectorAll('.flex.gap-2');
                    if (rows.length > 1) {
                        e.target.closest('.flex.gap-2').remove();
                    }
                }
            });

            // Initialize the inputs based on selected type
            toggleColorPickers();
        });

        function updateColorValue(colorPicker) {
            const valueInput = colorPicker.previousElementSibling;
            valueInput.value = colorPicker.value;
        }
    </script>
@endpush
