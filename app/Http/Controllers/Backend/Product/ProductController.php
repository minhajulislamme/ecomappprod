<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function AllProduct()
    {
        $categories = Category::where('status', 'active')->latest()->get();
        $subcategories = SubCategory::where('status', 'active')->latest()->get();
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.product.all_product', compact('categories', 'subcategories', 'products'));
    } //end method

    public function ProductAdd()
    {
        $categories = Category::where('status', 'active')->latest()->get();

        return view('admin.product.add_product', compact('categories'));
    } //end method

    public function StoreProduct(Request $request)
    {
        $manager = new ImageManager(new Driver());

        // Handle main thumbnail
        $image = $request->file('product_thambnail');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $manager->read($image->getRealPath())
            ->resize(800, 800)
            ->save(public_path('upload/products/thambnail/' . $name_gen));
        $save_url = 'upload/products/thambnail/' . $name_gen;

        $product_id = Product::insertGetId([

            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),

            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'product_tags' => $request->product_tags,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,

            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,

            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,

            'product_thambnail' => $save_url,
            'vendor_id' => $request->vendor_id,
            'status' => 1,
            'created_at' => Carbon::now(),

        ]);

        // Multiple Image Upload
        if ($request->hasFile('multi_img')) {
            $images = $request->file('multi_img');
            foreach ($images as $img) {
                $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

                $manager->read($img->getRealPath())
                    ->resize(800, 800)
                    ->save(public_path('upload/products/multi-image/' . $make_name));

                $uploadPath = 'upload/products/multi-image/' . $make_name;

                ProductImage::create([
                    'product_id' => $product_id,
                    'photo_name' => $uploadPath,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    } // End Method 

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
            'subcategory_id' => 'required',
            'product_code' => 'required',
            'product_qty' => 'required|numeric|min:0',
            'product_tags' => 'required',
            'selling_price' => 'required|numeric',
            'short_descp' => 'required',
            'long_descp' => 'required',
        ]);

        try {
            $product = Product::findOrFail($id);
            $save_url = $product->product_thambnail;

            if ($request->hasFile('product_thambnail')) {
                // Delete old image
                if ($product->product_thambnail && file_exists(public_path($product->product_thambnail))) {
                    unlink(public_path($product->product_thambnail));
                }

                // Save new image
                $manager = new ImageManager(new Driver());
                $image = $request->file('product_thambnail');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $manager->read($image->getRealPath())
                    ->resize(800, 800)
                    ->save(public_path('upload/products/thambnail/' . $name_gen));

                $save_url = 'upload/products/thambnail/' . $name_gen;
            }

            $product->update([
                'brand_id' => $request->brand_id,
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'product_name' => $request->product_name,
                'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
                'product_code' => $request->product_code,
                'product_qty' => $request->product_qty,
                'product_tags' => $request->product_tags,
                'selling_price' => $request->selling_price,
                'discount_price' => $request->discount_price,
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'product_thambnail' => $save_url,
            ]);

            // Handle Multiple Images
            if ($request->hasFile('multi_img')) {
                $manager = new ImageManager(new Driver());

                // Delete old images
                $oldImages = ProductImage::where('product_id', $id)->get();
                foreach ($oldImages as $img) {
                    if (file_exists(public_path($img->photo_name))) {
                        unlink(public_path($img->photo_name));
                    }
                    $img->delete();
                }

                // Upload new images
                $images = $request->file('multi_img');
                foreach ($images as $img) {
                    $make_name = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();

                    $manager->read($img->getRealPath())
                        ->resize(800, 800)
                        ->save(public_path('upload/products/multi-image/' . $make_name));

                    $uploadPath = 'upload/products/multi-image/' . $make_name;

                    ProductImage::create([
                        'product_id' => $id,
                        'photo_name' => $uploadPath,
                        'created_at' => Carbon::now(),
                    ]);
                }
            }

            return redirect()->route('all.product')->with('message', 'Product Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function DeleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Delete main thumbnail
            if ($product->product_thambnail && file_exists(public_path($product->product_thambnail))) {
                unlink(public_path($product->product_thambnail));
            }

            // Delete multiple images
            $multipleImages = ProductImage::where('product_id', $id)->get();
            foreach ($multipleImages as $img) {
                if (file_exists(public_path($img->photo_name))) {
                    unlink(public_path($img->photo_name));
                }
                $img->delete();
            }

            $product->delete();
            return redirect()->back()->with('message', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
