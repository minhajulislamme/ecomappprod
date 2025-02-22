<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class SubcategoryController extends Controller
{
    /**
     * Display all subcategories
     */
    public function AllSubCategory()
    {
        try {
            $subcategories = SubCategory::with(['category' => function ($query) {
                $query->select('id', 'category_name', 'status');
            }])
                ->whereHas('category', function ($query) {
                    $query->where('status', 'active');
                })
                ->select('id', 'category_id', 'subcategory_name', 'subcategory_slug', 'status')
                ->latest()
                ->get();

            return view('admin.category.all_sub_category', compact('subcategories'));
        } catch (Exception $e) {
            Log::error('Error fetching subcategories: ' . $e->getMessage());
            return $this->errorResponse('Failed to fetch subcategories');
        }
    }

    /**
     * Show subcategory creation form
     */
    public function SubCategoryAdd()
    {
        try {
            $categories = Category::where('status', 'active')
                ->select('id', 'category_name')
                ->orderBy('category_name')
                ->get();

            return view('admin.category.add_sub_category', compact('categories'));
        } catch (Exception $e) {
            Log::error('Error loading subcategory form: ' . $e->getMessage());
            return $this->errorResponse('Failed to load subcategory form');
        }
    }

    /**
     * Store new subcategory
     */
    public function SubCategoryStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id,status,active',
            'subcategory_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:sub_categories,subcategory_name',
                'regex:/^[a-zA-Z0-9\s-]+$/'
            ],
        ], [
            'category_id.exists' => 'Selected category is invalid or inactive',
            'subcategory_name.regex' => 'Subcategory name can only contain letters, numbers, spaces and hyphens'
        ]);

        try {
            SubCategory::create([
                'category_id' => $request->category_id,
                'subcategory_name' => trim($request->subcategory_name),
                'subcategory_slug' => Str::slug($request->subcategory_name),
                'status' => 'active'
            ]);

            return redirect()
                ->route('all.subcategory')
                ->with('success', 'Subcategory Added Successfully');
        } catch (Exception $e) {
            Log::error('Error creating subcategory: ' . $e->getMessage());
            return $this->errorResponse('Failed to create subcategory');
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

    /**
     * Update subcategory
     */
    public function SubCategoryUpdate(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id,status,active',
            'subcategory_name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:sub_categories,subcategory_name,' . $subcategory->id,
                'regex:/^[a-zA-Z0-9\s-]+$/'
            ],
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $subcategory->update([
                'category_id' => $request->category_id,
                'subcategory_name' => trim($request->subcategory_name),
                'subcategory_slug' => Str::slug($request->subcategory_name),
                'status' => $request->status,
            ]);

            $notification = [
                'message' => 'Subcategory Updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()
                ->route('all.subcategory')
                ->with($notification);
        } catch (Exception $e) {
            Log::error('Error updating subcategory: ' . $e->getMessage());

            $notification = [
                'message' => 'Failed to update subcategory',
                'alert-type' => 'error'
            ];

            return back()
                ->withInput()
                ->with($notification);
        }
    }

    /**
     * Delete subcategory
     */
    public function SubCategoryDelete($id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);

            // Check if subcategory has related products
            if ($subcategory->products()->exists()) {
                return back()->with('error', 'Cannot delete subcategory with associated products');
            }

            $subcategory->delete();
            return redirect()
                ->route('all.subcategory')
                ->with('success', 'Subcategory Deleted Successfully');
        } catch (Exception $e) {
            Log::error('Error deleting subcategory: ' . $e->getMessage());
            return $this->errorResponse('Failed to delete subcategory');
        }
    }

    /**
     * Get subcategories for API
     */
    public function getSubcategories($categoryId)
    {
        try {
            $subcategories = SubCategory::where('category_id', $categoryId)
                ->where('status', 'active')
                ->select('id', 'subcategory_name')
                ->get();

            return response()->json($subcategories);
        } catch (Exception $e) {
            Log::error('Error fetching subcategories API: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch subcategories'], 500);
        }
    }

    /**
     * Helper method for error responses
     */
    private function errorResponse($message)
    {
        return back()
            ->withInput()
            ->with('error', $message);
    }
}
