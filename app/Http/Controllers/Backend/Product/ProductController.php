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
        return view('admin.product.add_product', compact('categories', 'attributes'));
    }

    public function ProductStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'stock' => 'required|integer|min:0',
            'thumbnail_image' => 'required|image|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|array'
        ]);

        try {
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'stock' => $request->stock,
                'thumbnail_image' => $this->uploadImage($request->file('thumbnail_image'), 'thumbnail'),
                'gallery_images' => $this->handleGalleryImages($request->file('gallery_images') ?? []),
                'status' => $request->status
            ]);

            // Handle attributes
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

    protected function uploadImage($image, $type)
    {
        if (!$image) return '';

        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = "upload/products/$type";

        if (!is_dir(public_path($path))) {
            mkdir(public_path($path), 0755, true);
        }

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image);

        // Standardize image sizes
        switch ($type) {
            case 'thumbnail':
                $img->cover(300, 300); // Thumbnail for listings
                break;
            case 'gallery':
                $img->cover(600, 600); // Gallery images
                break;
        }

        // Optimize image quality
        $img->toJpeg(80); // Convert to JPEG with 80% quality

        $img->save(public_path("$path/$filename"));
        return "$path/$filename";
    }

    protected function handleGalleryImages($images)
    {
        if (!is_array($images)) return [];

        return array_filter(array_map(function ($image) {
            return $image && $image->isValid() ? $this->uploadImage($image, 'gallery') : null;
        }, $images));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'stock' => 'required|integer|min:0',
            'thumbnail_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'attributes' => 'nullable|array',
            'status' => 'required|in:active,inactive,draft'
        ]);

        try {
            $product = Product::findOrFail($id);

            // Update basic product information
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'stock' => $request->stock,
                'status' => $request->status,
            ]);

            // Handle thumbnail image
            if ($request->hasFile('thumbnail_image')) {
                if ($product->thumbnail_image) {
                    $this->deleteImage($product->thumbnail_image);
                }
                $product->thumbnail_image = $this->uploadImage($request->file('thumbnail_image'), 'thumbnail');
                $product->save();
            }

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                if ($product->gallery_images) {
                    foreach ($product->gallery_images as $oldImage) {
                        $this->deleteImage($oldImage);
                    }
                }
                $product->gallery_images = $this->handleGalleryImages($request->file('gallery_images'));
                $product->save();
            }

            // Handle attributes
            // First, delete existing attributes
            ProductAttribute::where('product_id', $product->id)->delete();

            // Then create new attributes if any
            if ($request->has('attributes')) {
                $this->saveProductAttributes($product, $request->input('attributes', []));
            }

            return redirect()
                ->route('all.product')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error updating product: ' . $e->getMessage());
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
            $product = Product::findOrFail($id);

            // Delete images
            $this->deleteImage($product->thumbnail_image);

            if ($product->gallery_images) {
                foreach ($product->gallery_images as $image) {
                    $this->deleteImage($image);
                }
            }

            // Delete product attributes using the model
            ProductAttribute::where('product_id', $product->id)->delete();

            // Delete the product
            $product->delete();

            return redirect()
                ->route('all.product')
                ->with('success', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
