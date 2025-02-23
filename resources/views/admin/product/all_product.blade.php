@extends('admin.admin_dashboard')

@section('admin_content')
    <div class="p-6">
        <div class="bg-white shadow-md rounded-md border border-gray-100 p-6">
            <!-- Header -->
            <div class="flex justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold">Products</h2>
                    <p class="text-sm text-gray-500">Manage your products</p>
                </div>
                <a href="{{ route('product.add') }}" class="btn-primary">
                    <i class="ri-add-line mr-1"></i>Add Product
                </a>
            </div>

            <!-- Filters -->
            <div class="flex justify-between mb-4">
                <select id="perPage" class="form-select w-32">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                </select>

                <div class="relative w-64">
                    <input id="searchInput" type="text" class="form-input pl-10" placeholder="Search products...">
                    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Products Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px]" id="productsTable">
                    <thead>
                        <tr>
                            <th class="table-th">#</th>
                            <th class="table-th">Product</th>
                            <th class="table-th">Category</th>
                            <th class="table-th">Price</th>
                            <th class="table-th">Stock</th>
                            <th class="table-th">Attributes</th>
                            <th class="table-th">Status</th>
                            <th class="table-th">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $key => $product)
                            <tr class="border-b border-gray-100">
                                <td class="table-td">{{ $key + 1 }}</td>
                                <td class="table-td">
                                    <div class="flex items-center">
                                        <img src="{{ asset($product->thumbnail_image) }}" alt="{{ $product->name }}"
                                            class="w-10 h-10 rounded-md object-cover">
                                        <div class="ml-3">
                                            <div class="font-medium">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-td">
                                    <div>{{ $product->category->category_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $product->subcategory->subcategory_name }}</div>
                                </td>
                                <td class="table-td">${{ number_format($product->price, 2) }}</td>
                                <td class="table-td">
                                    <span class="@if ($product->stock < 10) text-red-500 @endif">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="table-td">
                                    @forelse ($product->productAttributes as $productAttribute)
                                        <div class="mb-1">
                                            <span class="font-medium">
                                                {{ optional($productAttribute->attribute)->attribute_name ?? 'N/A' }}:
                                            </span>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @if (is_array($productAttribute->values))
                                                    @foreach ($productAttribute->values as $value)
                                                        @if (optional($productAttribute->attribute)->attribute_type === 'color')
                                                            <span
                                                                class="inline-block w-4 h-4 rounded-full border border-gray-200"
                                                                style="background-color: {{ $value }}"
                                                                title="{{ $value }}">
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-block px-2 py-1 text-xs bg-gray-100 rounded">
                                                                {{ $value }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-gray-400">No attributes</span>
                                    @endforelse
                                </td>
                                <td class="table-td">
                                    <span class="status-badge status-{{ $product->status }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn-icon"
                                            title="Edit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <button onclick="deleteProduct({{ $product->id }})" class="btn-icon text-red-500"
                                            title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="table-td text-center py-8">
                                    No products found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                const searchInput = document.getElementById('searchInput');
                const table = document.getElementById('productsTable');
                const rows = Array.from(table.getElementsByTagName('tr')).slice(1);

                searchInput.addEventListener('keyup', function() {
                    const query = this.value.toLowerCase();
                    rows.forEach(row => {
                        const shouldShow = Array.from(row.cells).some(cell =>
                            cell.textContent.toLowerCase().includes(query)
                        );
                        row.style.display = shouldShow ? '' : 'none';
                    });
                });

                // Delete confirmation with error handling
                window.deleteProduct = function(productId) {
                    if (confirm('Are you sure you want to delete this product?')) {
                        try {
                            window.location.href = `/product/delete/${productId}`;
                        } catch (error) {
                            console.error('Error deleting product:', error);
                            alert('Failed to delete product. Please try again.');
                        }
                    }
                };
            });
        </script>
    @endpush

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

            .status-draft {
                @apply bg-yellow-100 text-yellow-700;
            }
        </style>
    @endpush
@endsection
