<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductAttribute;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $products = Product::with(['category', 'subcategory', 'productAttributes'])->latest()->get();
        return view('admin.product.all_product', compact('products'));
    }

    public function ProductAdd()
    {
        $categories = Category::active()->get();
        $attributes = Attribute::where('status', 'active')->get();
        $subcategories = []; // Initialize empty subcategories array
        return view('admin.product.add_product', compact('categories', 'attributes', 'subcategories'));
    }

    protected function uploadImage($image, $type)
    {
        if (!$image) return '';

        $filename = uniqid() . '.webp';
        $path = "upload/products/$type";

        // Ensure upload directory exists
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);

        // Standardize all images to 800x800
        $img->cover(800, 800);

        // Convert to WebP with quality optimization
        $img->toWebp(85);

        $img->save(public_path("$path/$filename"));
        return "$path/$filename";
    }

    protected function handleGalleryImages($images)
    {
        if (!is_array($images)) return [];

        $galleryImages = [];
        foreach ($images as $image) {
            if ($image && $image->isValid()) {
                $galleryImages[] = $this->uploadImage($image, 'gallery');
            }
        }
        return array_filter($galleryImages);
    }

    protected function handleImages($product, $request)
    {
        // Handle thumbnail image
        if ($request->hasFile('thumbnail_image')) {
            // Delete old thumbnail if exists
            if ($product && !empty($product->thumbnail_image)) {
                $this->deleteImage($product->thumbnail_image);
            }
            $thumbnailPath = $this->uploadImage($request->file('thumbnail_image'), 'thumbnail');
        } else {
            $thumbnailPath = $product ? $product->thumbnail_image : '';
        }

        // Handle gallery images
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images if they exist
            if ($product && !empty($product->gallery_images)) {
                foreach ($product->gallery_images as $oldImage) {
                    $this->deleteImage($oldImage);
                }
            }
            $galleryImages = $this->handleGalleryImages($request->file('gallery_images'));
        } else {
            $galleryImages = $product ? $product->gallery_images : [];
        }

        return [
            'thumbnail_image' => $thumbnailPath,
            'gallery_images' => $galleryImages
        ];
    }

    public function ProductStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'stock' => 'required|integer|min:0',
            'thumbnail_image' => 'required|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
            'attributes' => 'nullable|array',
        ]);

        try {
            // Check if we're updating an existing product
            $existingProduct = Product::find($request->id);

            // Handle image uploads
            $images = $this->handleImages($existingProduct, $request);

            $product = Product::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $validated['name'],
                    'short_description' => $request->short_description,
                    'description' => $request->description,
                    'price' => $validated['price'],
                    'discount_price' => $request->discount_price,
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'],
                    'stock' => $validated['stock'],
                    'is_featured' => $request->is_featured ?? 'no',
                    'is_trending' => $request->is_trending ?? 'no',
                    'is_best_selling' => $request->is_best_selling ?? 'no',
                    'is_offer' => $request->is_offer ?? 'no',
                    'thumbnail_image' => $images['thumbnail_image'],
                    'gallery_images' => $images['gallery_images'],
                    'status' => 'active',
                ]
            );

            if ($request->has('attributes')) {
                $this->saveProductAttributes($product, $request->input('attributes', []));
            }

            return redirect()->route('all.product')->with('success', 'Product Added Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    protected function saveProductAttributes($product, array $attributes)
    {
        foreach ($attributes as $attributeId => $values) {
            if (is_array($values) && !empty($values)) {
                ProductAttribute::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeId,
                    'values' => array_values(array_filter($values))
                ]);
            }
        }
    }

    protected function deleteImage($path)
    {
        $fullPath = public_path($path);
        if ($path && file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function GetSubcategories($categoryId)
    {
        return SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->select('id', 'subcategory_name')
            ->get();
    }

    public function ProductUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'stock' => 'required|integer|min:0',
            'thumbnail_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120',
        ]);

        try {
            $product = Product::findOrFail($id);

            // Handle image uploads
            $images = $this->handleImages($product, $request);

            // Update product with new data
            $product->fill($validated);
            $product->description = $request->description;
            $product->status = $request->status ?? 'draft';
            $product->thumbnail_image = $images['thumbnail_image'];
            $product->gallery_images = $images['gallery_images'];
            $product->save();

            // Update attributes
            ProductAttribute::where('product_id', $product->id)->delete();
            if ($request->has('attributes')) {
                $this->saveProductAttributes($product, $request->input('attributes', []));
            }

            return redirect()->route('all.product')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function ProductEdit($id)
    {
        try {
            $product = Product::with(['category', 'subcategory', 'productAttributes'])->findOrFail($id);
            $categories = Category::where('status', 'active')->get();
            $subcategories = SubCategory::where('category_id', $product->category_id)
                ->where('status', 'active')
                ->get();
            $attributes = Attribute::where('status', 'active')->get();

            // Prepare existing attribute values
            $existingAttributes = $product->productAttributes->pluck('values', 'attribute_id')->toArray();

            return view('admin.product.edit_product', compact(
                'product',
                'categories',
                'subcategories',
                'attributes',
                'existingAttributes'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load product: ' . $e->getMessage());
        }
    }

    public function ProductDelete($id)
    {
        try {
            $product = Product::with(['variations', 'productAttributes'])->findOrFail($id);

            // Delete all related attributes
            $product->productAttributes()->delete();

            // Delete variations and their images
            foreach ($product->variations as $variation) {
                if ($variation->variation_image && file_exists(public_path($variation->variation_image))) {
                    unlink(public_path($variation->variation_image));
                }
                $variation->delete();
            }

            // Delete product images
            if ($product->thumbnail_image && file_exists(public_path($product->thumbnail_image))) {
                unlink(public_path($product->thumbnail_image));
            }

            if (!empty($product->gallery_images)) {
                foreach ($product->gallery_images as $image) {
                    if (file_exists(public_path($image))) {
                        unlink(public_path($image));
                    }
                }
            }

            // Delete the product
            // $product->forceDelete();
            $product->delete();

            return redirect()->route('all.product')->with([
                'message' => 'Product and all related data successfully deleted',
                'alert-type' => 'success'
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Failed to delete product',
                'alert-type' => 'error'
            ]);
        }
    }
}
