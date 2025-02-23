@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="p-6 bg-white shadow-md rounded-md border border-gray-100">
            <!-- Header -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Edit Product</h2>
                    <p class="text-sm text-gray-500">Update product details</p>
                </div>
                <a href="{{ route('all.product') }}" class="btn-primary">
                    <i class="ri-file-list-line mr-1"></i>All Products
                </a>
            </div>

            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                // ...existing basic fields code...

                <!-- Attributes -->
                @if (isset($attributes) && count($attributes) > 0)
                    <div class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">Product Attributes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($attributes as $attribute)
                                @php
                                    $existingValues =
                                        $product->attributes->where('attribute_id', $attribute->id)->first()?->values ??
                                        [];
                                @endphp
                                <div class="attribute-group p-3 border rounded">
                                    <h4 class="font-medium mb-2">{{ $attribute->attribute_name }}</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach (json_decode($attribute->attribute_value) as $value)
                                            <label class="attribute-option">
                                                <input type="checkbox" name="attributes[{{ $attribute->id }}][]"
                                                    value="{{ $value }}"
                                                    {{ in_array($value, $existingValues) ? 'checked' : '' }}
                                                    class="form-checkbox">
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

                // ...existing code...
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ...existing code...

                // Add validation for attributes
                document.querySelector('form').addEventListener('submit', function(e) {
                    const attributeGroups = document.querySelectorAll('.attribute-group');
                    let hasSelectedAttribute = false;

                    attributeGroups.forEach(group => {
                        const checkedBoxes = group.querySelectorAll('input[type="checkbox"]:checked');
                        if (checkedBoxes.length > 0) {
                            hasSelectedAttribute = true;
                        }
                    });

                    if (!hasSelectedAttribute) {
                        if (!confirm('No attributes selected. Do you want to continue?')) {
                            e.preventDefault();
                        }
                    }
                });
            });
        </script>
    @endpush

    // ...existing styles...
@endsection
