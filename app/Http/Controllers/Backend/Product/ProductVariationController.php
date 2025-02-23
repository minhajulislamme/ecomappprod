<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\ValidationException;

class ProductVariationController extends Controller
{
    private function ensureUploadDirectoryExists()
    {
        $path = public_path('upload/variation_images');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

    private $namedColors = [
        'black' => '#000000',
        'white' => '#ffffff',
        'red' => '#ff0000',
        'green' => '#008000',
        'blue' => '#0000ff',
        'yellow' => '#ffff00',
        'purple' => '#800080',
        'orange' => '#ffa500',
        'brown' => '#a52a2a',
        'pink' => '#ffc0cb',
        'gray' => '#808080',
        'silver' => '#c0c0c0'
    ];

    private function validateColorValue($color)
    {
        // Convert named colors to hex
        $color = strtolower(trim($color));
        if (isset($this->namedColors[$color])) {
            return $this->namedColors[$color];
        }

        // Check if it's a valid hex color
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return $color;
        }

        // Check if it's an RGB color
        if (preg_match('/^rgb\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*\)$/', $color)) {
            return $this->rgbToHex($color);
        }

        // Try to parse as a CSS color name
        try {
            $color = $this->cssColorNameToHex($color);
            if ($color) {
                return $color;
            }
        } catch (\Exception $e) {
            // Ignore conversion errors
        }

        // If not a valid color format, return null
        return null;
    }

    private function rgbToHex($rgb)
    {
        if (preg_match('/^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/', $rgb, $matches)) {
            $r = intval($matches[1]);
            $g = intval($matches[2]);
            $b = intval($matches[3]);
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        }
        return null;
    }

    private function cssColorNameToHex($colorName)
    {
        // Create a temporary div element with the color
        $color = shell_exec("node -e \"
            process.stdout.write(
                require('css-color-names')['" . strtolower($colorName) . "'] || ''
            )
        \"");

        return $color ?: null;
    }

    private function formatAttributeValues($product, $attributeValues)
    {
        $formattedValues = [];
        foreach ($attributeValues as $name => $value) {
            $attribute = $product->productAttributes()
                ->whereHas('attribute', function ($q) use ($name) {
                    $q->where('attribute_name', $name);
                })
                ->first()?->attribute;

            if ($attribute && $attribute->attribute_type === 'color') {
                // Validate and format color value
                $validatedColor = $this->validateColorValue($value);

                if ($validatedColor) {
                    $formattedValues[$name] = $validatedColor;
                } else {
                    // Check if it's a predefined color value
                    $attributeValues = json_decode($attribute->attribute_value, true) ?? [];
                    if (in_array($value, $attributeValues)) {
                        $formattedValues[$name] = $value;
                    } else {
                        // Default to a safe color if validation fails
                        $formattedValues[$name] = '#000000';
                    }
                }
            } else {
                $formattedValues[$name] = $value;
            }
        }
        return $formattedValues;
    }

    public function index(Product $product)
    {
        $variations = $product->variations()->with('product')->get();
        return view('admin.product.variation.index', compact('product', 'variations'));
    }

    private function getProductAttributes(Product $product)
    {
        $attributesWithValues = [];

        // Get only the attributes that are assigned to this product
        $productAttributes = $product->productAttributes()
            ->with('attribute')
            ->whereNotNull('values') // Only get attributes that have values
            ->get();

        foreach ($productAttributes as $productAttribute) {
            $attribute = $productAttribute->attribute;
            if ($attribute && !empty($productAttribute->values)) {
                $attributeValues = $productAttribute->values;

                // Format color values if needed
                if ($attribute->attribute_type === 'color') {
                    $attributeValues = array_map(function ($value) {
                        return $this->validateColorValue($value) ?? $value;
                    }, $attributeValues);
                }

                $attributesWithValues[] = [
                    'id' => $attribute->id,
                    'name' => $attribute->attribute_name,
                    'type' => $attribute->attribute_type,
                    'values' => $attributeValues
                ];
            }
        }

        return $attributesWithValues;
    }

    public function create(Product $product)
    {
        $attributesWithValues = $this->getProductAttributes($product);

        if (empty($attributesWithValues)) {
            return redirect()->route('admin.products.variations.index', $product)
                ->with('error', 'Please add attributes to the product before creating variations.');
        }

        return view('admin.product.variation.create', compact('product', 'attributesWithValues'));
    }

    private function validateProductAttributes(Product $product)
    {
        $configuredAttributes = $product->activeProductAttributes()->with('attribute')->get();

        if ($configuredAttributes->isEmpty()) {
            throw ValidationException::withMessages([
                'attributes' => 'This product has no configured attributes. Please add attributes before creating variations.'
            ]);
        }
    }

    public function store(Request $request, Product $product)
    {
        try {
            $this->validateProductAttributes($product);
            $this->validateRequest($request, $product);

            $data = $request->except('image');
            $data['attribute_values'] = $this->formatAttributeValues($product, $request->attribute_values);

            if ($request->hasFile('image')) {
                $data['image'] = $this->handleImageUpload($request->file('image'));
            }

            $variation = $product->variations()->create($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with('success', 'Variation created successfully');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create variation. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Product $product, ProductVariation $variation)
    {
        $attributesWithValues = $this->getProductAttributes($product);

        if (empty($attributesWithValues)) {
            return redirect()->route('admin.products.variations.index', $product)
                ->with('error', 'No attributes found for this product.');
        }

        // Add selected values to attributes
        foreach ($attributesWithValues as &$attribute) {
            $attribute['selected'] = $variation->attribute_values[$attribute['name']] ?? null;
        }

        return view('admin.product.variation.edit', compact('product', 'variation', 'attributesWithValues'));
    }

    public function update(Request $request, Product $product, ProductVariation $variation)
    {
        try {
            $this->validateProductAttributes($product);
            $this->validateRequest($request, $product, $variation);

            $data = $request->except('image');
            $data['attribute_values'] = $this->formatAttributeValues($product, $request->attribute_values);

            if ($request->hasFile('image')) {
                $data['image'] = $this->handleImageUpload($request->file('image'), $variation->image);
            }

            $variation->update($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with('success', 'Variation updated successfully');
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update variation. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Product $product, ProductVariation $variation)
    {
        if ($variation->image && file_exists(public_path($variation->image))) {
            unlink(public_path($variation->image));
        }

        $variation->delete();

        return redirect()->route('admin.products.variations.index', $product)
            ->with('success', 'Variation deleted successfully');
    }

    private function validateRequest(Request $request, Product $product, ?ProductVariation $variation = null)
    {
        $rules = [
            'sku' => 'required|unique:product_variations,sku' . ($variation ? ',' . $variation->id : ''),
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'attribute_values' => 'required|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        // Get configured attributes from the product
        $configuredAttributes = $product->activeProductAttributes()->with('attribute')->get();

        // Add validation rules for each configured attribute
        foreach ($configuredAttributes as $productAttribute) {
            if ($productAttribute->attribute && !empty($productAttribute->values)) {
                $attributeName = $productAttribute->attribute->attribute_name;
                $rules["attribute_values.{$attributeName}"] = [
                    'required',
                    'in:' . implode(',', $productAttribute->values)
                ];
            }
        }

        // Custom validation messages
        $messages = [
            'sale_price.lt' => 'Sale price must be less than the regular price.'
        ];

        return $request->validate($rules, $messages);
    }

    private function handleImageUpload($image, $oldImage = null)
    {
        $this->ensureUploadDirectoryExists();

        if ($oldImage && file_exists(public_path($oldImage))) {
            unlink(public_path($oldImage));
        }

        $manager = new ImageManager(new Driver());
        $imageName = date('YmdHi') . $image->getClientOriginalName();

        $img = $manager->read($image);

        // Maintain aspect ratio while resizing
        $img->scale(width: 800);

        // Optimize image quality
        $img->toJpeg(80);

        $path = 'upload/variation_images/' . $imageName;
        $img->save(public_path($path));

        return $path;
    }
}
