@extends('admin.admin_dashboard')
@section('admin_content')
    <div class="p-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex justify-between mb-4 items-start">
                <div>
                    <div class="text-lg font-semibold">Edit Product</div>
                </div>
            </div>

            <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                        <input type="text" name="product_name" value="{{ $product->product_name }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <select name="category_id" id="category_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Subcategory</label>
                        <select name="subcategory_id" id="subcategory_id"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                    {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->subcategory_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="product_qty" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" name="product_qty" value="{{ $product->product_qty }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="selling_price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" step="0.01" name="selling_price" value="{{ $product->selling_price }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="discount_price" class="block text-sm font-medium text-gray-700">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" value="{{ $product->discount_price }}"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="product_thumbnail" class="block text-sm font-medium text-gray-700">Product Image</label>
                        <input type="file" name="product_thumbnail"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        <img src="{{ asset($product->product_thumbnail) }}" class="w-20 h-20 object-cover mt-2"
                            alt="">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="product_description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="product_description" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">{{ $product->product_description }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
