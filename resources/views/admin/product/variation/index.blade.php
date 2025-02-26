@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="bg-white shadow-md rounded-md border border-gray-100 p-6">
            <!-- Header -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Product Variations</h2>
                    <p class="text-sm text-gray-500">Manage variations for {{ $product->name }}</p>
                </div>
                @if ($product->hasConfiguredAttributes())
                    <a href="{{ route('admin.products.variations.create', $product->id) }}" class="btn-primary">
                        <i class="ri-add-line mr-1"></i>Add Variation
                    </a>
                @else
                    <div class="flex items-center gap-2">
                        <button class="btn-disabled" disabled title="Add attributes to the product first">
                            <i class="ri-add-line mr-1"></i>Add Variation
                        </button>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn-secondary">
                            <i class="ri-settings-line mr-1"></i>Configure Attributes
                        </a>
                    </div>
                @endif
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (!$product->hasConfiguredAttributes())
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded mb-4">
                    <div class="flex items-start">
                        <i class="ri-information-line mt-0.5 mr-2"></i>
                        <div>
                            <p class="font-medium">Configuration Required</p>
                            <p class="mt-1">To create variations, you need to:</p>
                            <ol class="list-decimal list-inside mt-2 space-y-1">
                                <li>Go to product edit page</li>
                                <li>Add attributes to the product</li>
                                <li>Define values for each attribute</li>
                            </ol>
                            <div class="mt-3">
                                <a href="{{ route('product.edit', $product->id) }}"
                                    class="text-yellow-800 underline hover:text-yellow-900">
                                    Configure Product Attributes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Variations Table -->
            <div class="overflow-x-auto">
                @if ($product->hasConfiguredAttributes())
                    <table class="w-full min-w-[800px]">
                        <thead>
                            <tr>
                                <th class="table-th">#</th>
                                <th class="table-th">Image</th>
                                <th class="table-th">SKU</th>
                                <th class="table-th">Attributes</th>
                                <th class="table-th">Price</th>
                                <th class="table-th">Stock</th>
                                <th class="table-th">Status</th>
                                <th class="table-th">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($variations as $key => $variation)
                                <tr class="border-b border-gray-100">
                                    <td class="table-td">{{ $key + 1 }}</td>
                                    <td class="table-td">
                                        @if ($variation->variation_image)
                                            <img src="{{ asset($variation->variation_image) }}" alt="Variation"
                                                class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                                <i class="ri-image-line text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="table-td">{{ $variation->sku }}</td>
                                    <td class="table-td">
                                        <div class="space-y-2">
                                            @foreach ($variation->attribute_values as $attribute => $value)
                                                <div class="flex items-center gap-2">
                                                    <span class="text-gray-600 font-medium">{{ $attribute }}:</span>
                                                    @php
                                                        $attributeType = $product
                                                            ->productAttributes()
                                                            ->whereHas('attribute', function ($q) use ($attribute) {
                                                                $q->where('attribute_name', $attribute);
                                                            })
                                                            ->first()?->attribute?->attribute_type;
                                                    @endphp

                                                    @if ($attributeType === 'color')
                                                        <div class="flex items-center gap-1">
                                                            <div class="color-preview">
                                                                <div class="color-swatch"
                                                                    style="background-color: {{ $value }}"></div>
                                                            </div>
                                                            <span class="text-sm text-gray-600">{{ $value }}</span>
                                                        </div>
                                                    @else
                                                        <span class="px-2 py-1 bg-gray-100 rounded-full text-sm">
                                                            {{ $value }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="table-td">
                                        <div>${{ number_format($variation->price, 2) }}</div>
                                        @if ($variation->sale_price)
                                            <div class="text-sm text-green-600">
                                                Sale: ${{ number_format($variation->sale_price, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="table-td">
                                        <span class="@if ($variation->stock_quantity < 10) text-red-500 @endif">
                                            {{ $variation->stock_quantity }}
                                        </span>
                                    </td>
                                    <td class="table-td">
                                        <span
                                            class="status-badge {{ $variation->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                            {{ ucfirst($variation->status) }}
                                        </span>
                                    </td>
                                    <td class="table-td">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.products.variations.edit', [$product->id, $variation->id]) }}"
                                                class="btn-icon" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <form
                                                action="{{ route('admin.products.variations.destroy', [$product->id, $variation->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this variation?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon text-red-500" title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="table-td text-center py-8">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <i class="ri-product-hunt-line text-4xl text-gray-400"></i>
                                            <p class="text-gray-500">No variations found for this product</p>
                                            <a href="{{ route('admin.products.variations.create', $product->id) }}"
                                                class="btn-primary mt-2">
                                                <i class="ri-add-line mr-1"></i>Create First Variation
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .table-th {
                @apply text-sm font-medium text-gray-500 px-4 py-2 text-left bg-gray-50;
            }

            .table-td {
                @apply px-4 py-3 text-sm;
            }

            .btn-icon {
                @apply p-1 rounded-md hover:bg-gray-100 transition-colors;
            }

            .status-badge {
                @apply px-2 py-1 text-xs rounded-full font-medium;
            }

            .status-active {
                @apply bg-green-100 text-green-700;
            }

            .status-inactive {
                @apply bg-gray-100 text-gray-700;
            }

            .btn-primary {
                @apply px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 inline-flex items-center;
            }

            .color-preview {
                @apply relative;
            }

            .color-swatch {
                @apply w-6 h-6 rounded-lg border border-gray-200 shadow-sm;
            }

            /* Light color borders */
            .color-swatch[style*="background-color: #fff"],
            .color-swatch[style*="background-color: #ffffff"],
            .color-swatch[style*="background-color: rgb(255, 255, 255)"] {
                @apply border-gray-300;
            }

            .btn-disabled {
                @apply px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed inline-flex items-center;
            }

            .btn-secondary {
                @apply px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 inline-flex items-center;
            }
        </style>
    @endpush
@endsection
