<?php

namespace App\Http\Controllers\Backend\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CategoryController extends Controller
{
    public function AllCategory()
    {
      
        $categories = Category::latest()->get();
        return view('admin.category.all_category', compact('categories', ));
    }

    public function CategoryAdd()
    {
       
        return view('admin.category.add_category');
    }
    
}
