<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function AllCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.category.all_category', compact('categories'));
    }

    public function CategoryAdd()
    {
        return view('admin.category.add_category');
    }

    public function CategoryStore(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            $image = $request->file('category_image');
            $name_gen = hexdec(uniqid()) . '.webp';
            $save_url = 'upload/category/' . $name_gen;

            // Create directory if it doesn't exist
            if (!file_exists(public_path('upload/category'))) {
                mkdir(public_path('upload/category'), 0755, true);
            }

            // Initialize Intervention Image with GD driver
            $manager = new ImageManager(new Driver());

            // Load, resize, optimize and save the image as WebP
            $manager->read($image)
                ->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->toWebp(75)  // Convert to WebP with quality setting
                ->save(public_path($save_url));

            Category::create([
                'category_name' => $request->category_name,
                'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
                'category_image' => $save_url,
                'status' => 'active',
            ]);

            $notification = [
                'message' => 'Category Added Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.category')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    }

    public function CategoryEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.edit_category', compact('category'));
    }

    public function CategoryUpdate(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        try {
            $category = Category::findOrFail($request->id);

            // Update basic info
            $category->category_name = $request->category_name;
            $category->category_slug = strtolower(str_replace(' ', '-', $request->category_name));

            // Update status
            $category->status = $request->has('status') ? 'active' : 'inactive';

            // Handle image update
            if ($request->hasFile('category_image')) {
                // Delete old image
                if ($category->category_image && file_exists(public_path($category->category_image))) {
                    unlink(public_path($category->category_image));
                }

                $image = $request->file('category_image');
                $name_gen = hexdec(uniqid()) . '.webp';
                $save_url = 'upload/category/' . $name_gen;

                // Ensure directory exists
                if (!file_exists(public_path('upload/category'))) {
                    mkdir(public_path('upload/category'), 0755, true);
                }

                // Process and save new image
                $manager = new ImageManager(new Driver());
                $manager->read($image)
                    ->resize(800, 800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(75)  // Convert to WebP with quality setting
                    ->save(public_path($save_url));

                $category->category_image = $save_url;
            }

            $category->save();

            $notification = [
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('all.category')->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification)->withInput();
        }
    }

    public function CategoryDelete($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Delete all related products and their files
            foreach ($category->products as $product) {
                // Delete product attributes
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

                $product->delete();
            }

            // Delete all related subcategories
            foreach ($category->subcategories as $subcategory) {
                if ($subcategory->subcategory_image && file_exists(public_path($subcategory->subcategory_image))) {
                    unlink(public_path($subcategory->subcategory_image));
                }
                $subcategory->delete();
            }

            // Delete category image
            if ($category->category_image && file_exists(public_path($category->category_image))) {
                unlink(public_path($category->category_image));
            }

            $category->delete();

            $notification = [
                'message' => 'Category, Products, and Related Data Deleted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            return back()->with($notification);
        }
    }
}
