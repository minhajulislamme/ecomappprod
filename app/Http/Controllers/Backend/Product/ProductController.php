<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    public function AllProduct()
    {
        $products = Product::with(['category', 'subcategory', 'productAttributes'])->latest()->get();
        return view('admin.product.all_product', compact('products'));
    }

    public function ProductAdd()
    {
        $categories = Category::active()->get();
        $attributes = DB::table('attributes')->where('status', 'active')->get();
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
            'main_image' => 'required|image|max:5120',
            'thumbnail_image' => 'required|image|max:2048',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'stock' => $request->stock,
                'main_image' => $this->uploadImage($request->file('main_image'), 'main'),
                'thumbnail_image' => $this->uploadImage($request->file('thumbnail_image'), 'thumbnail'),
                'gallery_images' => $this->handleGalleryImages($request->file('gallery_images') ?? []),
                'status' => $request->status
            ]);

            // Handle attributes safely
            $attributes = $request->input('attributes', []);
            if (is_array($attributes)) {
                foreach ($attributes as $attributeId => $values) {
                    // Ensure values is an array and not empty
                    $attributeValues = is_array($values) ? array_filter($values) : [];

                    if (!empty($attributeValues)) {
                        ProductAttribute::create([
                            'product_id' => $product->id,
                            'attribute_id' => $attributeId,
                            'values' => array_values($attributeValues) // Reindex array
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('all.product')->with('success', 'Product Added Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    public function uploadImage($image, $type)
    {
        if (!$image) return '';

        $filename = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $path = "upload/products/$type";

        if (!File::exists(public_path($path))) {
            File::makeDirectory(public_path($path), 0755, true);
        }

        $img = $this->imageManager->read($image);

        // Simple resize logic
        if ($type == 'main') {
            $img->resize(800, null, fn($constraint) => $constraint->aspectRatio());
        } elseif ($type == 'thumbnail') {
            $img->resize(300, 300, fn($constraint) => $constraint->aspectRatio());
        } else {
            $img->resize(600, null, fn($constraint) => $constraint->aspectRatio());
        }

        $img->save(public_path("$path/$filename"));
        return "$path/$filename";
    }

    public function handleGalleryImages($images)
    {
        // Ensure images is an array
        if (!is_array($images)) {
            return [];
        }

        $galleryImages = [];
        foreach ($images as $image) {
            if ($image && $image->isValid()) {
                $galleryImages[] = $this->uploadImage($image, 'gallery');
            }
        }

        return !empty($galleryImages) ? $galleryImages : [];
    }

    public function deleteImage($path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'stock' => 'required|integer|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:active,inactive,draft',
            'attributes' => 'nullable|array',
            'attributes.*' => 'array',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            // Update basic product info
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'stock' => $request->stock,
                'status' => $request->status,
            ]);

            // Handle image updates
            if ($request->hasFile('main_image')) {
                $this->deleteImage($product->main_image);
                $product->main_image = $this->uploadImage($request->file('main_image'), 'main');
            }

            if ($request->hasFile('thumbnail_image')) {
                $this->deleteImage($product->thumbnail_image);
                $product->thumbnail_image = $this->uploadImage($request->file('thumbnail_image'), 'thumbnail');
            }

            // Handle gallery images safely
            if ($request->hasFile('gallery_images')) {
                $galleryFiles = $request->file('gallery_images');
                if (is_array($galleryFiles)) {
                    foreach ($product->gallery_images ?? [] as $oldImage) {
                        $this->deleteImage($oldImage);
                    }
                    $product->gallery_images = $this->handleGalleryImages($galleryFiles);
                    $product->save();
                }
            }

            $product->save();

            // Handle attributes safely
            $product->productAttributes()->delete();

            if ($request->has('attributes')) {
                $attributes = $request->input('attributes', []);
                if (is_array($attributes)) {
                    foreach ($attributes as $attributeId => $values) {
                        $attributeValues = is_array($values) ? array_filter($values) : [];
                        if (!empty($attributeValues)) {
                            ProductAttribute::create([
                                'product_id' => $product->id,
                                'attribute_id' => $attributeId,
                                'values' => array_values($attributeValues)
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()
                ->route('all.product')
                ->with('success', 'Product Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    public function ProductEdit($id)
    {
        try {
            $product = Product::with(['attributes'])->findOrFail($id);
            $categories = Category::where('status', 'active')->get();
            $subcategories = SubCategory::where('category_id', $product->category_id)
                ->where('status', 'active')
                ->get();
            $attributes = Attribute::where('status', 'active')->get();

            return view('admin.product.edit_product', compact('product', 'categories', 'subcategories', 'attributes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load product: ' . $e->getMessage());
        }
    }

    public function ProductDelete($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);

            // Delete images
            $this->deleteImage($product->main_image);
            $this->deleteImage($product->thumbnail_image);

            if ($product->gallery_images) {
                foreach ($product->gallery_images as $image) {
                    $this->deleteImage($image);
                }
            }

            // Delete product attributes
            $product->attributes()->delete();

            // Delete the product
            $product->delete();

            DB::commit();

            return redirect()
                ->route('all.product')
                ->with('success', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
}
