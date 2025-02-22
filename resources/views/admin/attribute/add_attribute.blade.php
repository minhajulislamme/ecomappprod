@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white items-center shadow-md shadow-black/5 rounded-md border border-gray-100 mb-6">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-lg font-semibold">Add New Attribute</div>
                    <div class="text-sm font-medium text-gray-400">Add new attribute to your store</div>
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
                <form action="{{ route('attribute.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Attribute Name Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Name</label>
                            <input type="text" name="attribute_name" value="{{ old('attribute_name') }}"
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
                                <option value="text">Text</option>
                                <option value="color">Color</option>
                            </select>
                        </div>
                    </div>

                    <!-- Attribute Values -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Attribute Values</label>
                        <div id="values-container" class="flex flex-wrap gap-2">
                            <div class="flex gap-2 w-full sm:w-auto">
                                <div class="flex gap-2 items-center value-input-group w-full sm:w-auto">
                                    <input type="text" name="attribute_values[]" required placeholder="Enter value"
                                        class="w-full sm:w-32 px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition value-input">
                                    <input type="color" class="color-picker hidden h-9 w-14 cursor-pointer"
                                        onchange="updateColorValue(this)">
                                    <button type="button"
                                        class="remove-value px-2 py-1 text-sm bg-red-500 text-white rounded-md">-</button>
                                    <button type="button"
                                        class="add-value px-2 py-1 text-sm bg-green-500 text-white rounded-md">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-start pt-4">
                        <button type="submit"
                            class="px-6 py-2.5 bg-orange-600 text-white font-medium text-sm rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orange-300 transition duration-200">
                            Add Attribute
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

            function toggleColorPickers() {
                const isColor = attributeType.value === 'color';
                document.querySelectorAll('.color-picker').forEach(picker => {
                    picker.classList.toggle('hidden', !isColor);
                });
                document.querySelectorAll('.value-input').forEach(input => {
                    input.setAttribute('placeholder', isColor ? 'Enter color name' : 'Enter value');
                });
            }

            attributeType.addEventListener('change', toggleColorPickers);

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-value')) {
                    const isColor = attributeType.value === 'color';
                    const newRow = document.createElement('div');
                    newRow.className = 'flex gap-2 w-full sm:w-auto';
                    newRow.innerHTML = `
                        <div class="flex gap-2 items-center value-input-group w-full sm:w-auto">
                            <input type="text" name="attribute_values[]" required
                                class="w-full sm:w-32 px-4 py-2 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition value-input"
                                placeholder="${isColor ? 'Enter color name' : 'Enter value'}">
                            <input type="color" class="color-picker ${!isColor ? 'hidden' : ''} h-9 w-14 cursor-pointer"
                                onchange="updateColorValue(this)">
                            <button type="button" class="remove-value px-2 py-1 text-sm bg-red-500 text-white rounded-md">-</button>
                            <button type="button" class="add-value px-2 py-1 text-sm bg-green-500 text-white rounded-md">+</button>
                        </div>
                    `;
                    container.appendChild(newRow);
                }

                if (e.target.classList.contains('remove-value')) {
                    e.target.closest('.flex.gap-2').remove();
                }
            });
        });

        function updateColorValue(colorPicker) {
            const valueInput = colorPicker.previousElementSibling;
            valueInput.value = colorPicker.value;
        }
    </script>
@endpush
