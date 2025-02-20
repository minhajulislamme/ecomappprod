<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function AllSubCategory()
    {
        $subcategories = SubCategory::with('category')
            ->whereHas('category', function ($query) {
                $query->where('status', 'active');
            })
            ->latest()
            ->get();
        return view('admin.category.all_sub_category', compact('subcategories'));
    }

    public function SubCategoryAdd()
    {
        $categories = Category::where('status', 'active')
            ->orderBy('category_name')
            ->get();
        return view('admin.category.add_sub_category', compact('categories'));
    }

    public function SubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|string|min:2|max:255|unique:sub_categories,subcategory_name',
        ]);

        try {
            SubCategory::create([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'subcategory_slug' => Str::slug($request->subcategory_name),
                'status' => 'active'
            ]);

            return redirect()
                ->route('all.subcategory')
                ->with('success', 'Subcategory created successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create subcategory');
        }
    }

    public function SubCategoryEdit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::where('status', 'active')
            ->orderBy('category_name')
            ->get();
        return view('admin.category.edit_sub_category', compact('categories', 'subcategory'));
    }

    public function SubCategoryUpdate(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_name' => 'required|string|min:2|max:255|unique:sub_categories,subcategory_name,' . $subcategory->id,
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $subcategory->update([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'subcategory_slug' => Str::slug($request->subcategory_name),
                'status' => $request->status,
            ]);

            return redirect()
                ->route('all.subcategory')
                ->with('success', 'Subcategory updated successfully');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update subcategory');
        }
    }

    public function SubCategoryDelete($id)
    {

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();



        $notification = [
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.subcategory')->with($notification);
    }
}
