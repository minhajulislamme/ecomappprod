<?php

namespace App\Http\Controllers\Backend\Attribute;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function AllAttribute()
    {
        $attributes = Attribute::orderBy('attribute_name')->get();
        return view('admin.attribute.all_attribute', compact('attributes'));
    } //end method

    public function AttributeAdd()
    {
        return view('admin.attribute.add_attribute');
    } //end method

    public function AttributeStore(Request $request)
    {
        $request->validate([
            'attribute_name' => 'required|string|max:255',
            'attribute_type' => 'required|in:text,color,number',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => function ($attribute, $value, $fail) use ($request) {
                if ($request->attribute_type === 'number' && !is_numeric($value)) {
                    $fail('The attribute value must be a number.');
                }
            },
        ]);

        // Create attribute with multiple values
        $attribute = new Attribute();
        $attribute->attribute_name = $request->attribute_name;
        $attribute->attribute_type = $request->attribute_type;

        // Convert to float if number type
        $values = $request->attribute_values;
        if ($request->attribute_type === 'number') {
            $values = array_map('floatval', $values);
        }
        
        $attribute->attribute_value = json_encode($values);
        $attribute->status = 'active';
        $attribute->save();

        $notification = [
            'message' => 'Attribute Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.attribute')->with($notification);
    } //end method

    public function AttributeEdit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('admin.attribute.edit_attribute', compact('attribute'));
    }

    public function AttributeUpdate(Request $request, $id)
    {
        $request->validate([
            'attribute_name' => 'required|string|max:255',
            'attribute_type' => 'required|in:text,color,number',
            'attribute_values' => 'required|array|min:1',
            'attribute_values.*' => function ($attribute, $value, $fail) use ($request) {
                if ($request->attribute_type === 'number' && !is_numeric($value)) {
                    $fail('The attribute value must be a number.');
                }
            },
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->attribute_name = $request->attribute_name;
        $attribute->attribute_type = $request->attribute_type;

        // Convert to float if number type
        $values = $request->attribute_values;
        if ($request->attribute_type === 'number') {
            $values = array_map('floatval', $values);
        }

        $attribute->attribute_value = json_encode($values);
        $attribute->status = $request->status;
        $attribute->save();

        $notification = [
            'message' => 'Attribute Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.attribute')->with($notification);
    }

    public function AttributeDelete($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        $notification = [
            'message' => 'Attribute Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.attribute')->with($notification);
    }
}
