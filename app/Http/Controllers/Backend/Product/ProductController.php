<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $products = Product::latest()->get();
        return view('admin.product.all_product', compact('categories', 'subcategories', 'products'));
    } //end method

    public function ProductAdd()
    {
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        return view('admin.product.add_product', compact('categories', 'subcategories'));
    } //end method

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'product_thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selling_price' => 'required|numeric',
            'product_qty' => 'required|numeric|min:0',
            'product_description' => 'required|min:10'
        ]);

        try {
            $save_url = null;
            if ($request->hasFile('product_thumbnail')) {
                $manager = new ImageManager(new Driver());
                $image = $request->file('product_thumbnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $manager->read($image->getRealPath())
                    ->resize(800, 800)
                    ->save(public_path('upload/products/' . $name_gen));

                $save_url = 'upload/products/' . $name_gen;
            }

            Product::create([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_thumbnail' => $save_url,
                'product_qty' => $request->product_qty,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'product_description' => $request->product_description,
                'status' => 1,
            ]);

            return redirect()->route('all.product')->with('message', 'Product Added Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    public function EditProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $categories = Category::latest()->get();
            $subcategories = Subcategory::latest()->get();
            return view('admin.product.edit_product', compact('product', 'categories', 'subcategories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Product not found');
        }
    }

    public function UpdateProduct(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'selling_price' => 'required|numeric',
            'product_qty' => 'required|numeric|min:0',
            'product_description' => 'required|min:10'
        ]);

        try {
            $product = Product::findOrFail($id);
            $save_url = $product->product_thumbnail;

            if ($request->hasFile('product_thumbnail')) {
                // Delete old image
                if ($product->product_thumbnail && file_exists(public_path($product->product_thumbnail))) {
                    unlink(public_path($product->product_thumbnail));
                }

                // Save new image
                $manager = new ImageManager(new Driver());
                $image = $request->file('product_thumbnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $manager->read($image->getRealPath())
                    ->resize(800, 800)
                    ->save(public_path('upload/products/' . $name_gen));

                $save_url = 'upload/products/' . $name_gen;
            }

            $product->update([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_thumbnail' => $save_url,
                'product_qty' => $request->product_qty,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'product_description' => $request->product_description,
            ]);

            return redirect()->route('all.product')->with('message', 'Product Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function DeleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete product image if exists
            if ($product->product_thumbnail && file_exists(public_path($product->product_thumbnail))) {
                unlink(public_path($product->product_thumbnail));
            }

            $product->delete();
            return redirect()->back()->with('message', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
