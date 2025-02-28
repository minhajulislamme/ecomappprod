<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductVariationController extends Controller
{
    public function index(Product $product)
    {
        $variations = $product->variations()->with('product')->get();
        return view('admin.product.variation.all_variation', compact('product', 'variations'));
    }

    public function create(Product $product)
    {
        $attributesWithValues = $this->getProductAttributes($product);

        if (empty($attributesWithValues)) {
            return redirect()->route('admin.products.variations.index', $product)
                ->with([
                    'message' => 'Unable to create variation: This product has no attributes configured. Please add product attributes first.',
                    'alert-type' => 'error'
                ]);
        }

        return view('admin.product.variation.add_variation', compact('product', 'attributesWithValues'));
    }

    public function store(Request $request, Product $product)
    {
        try {
            $this->validateProductAttributes($product);
            $this->validateRequest($request, $product);

            // Check if a variation with the same attribute combination already exists
            $attributeValues = $this->formatAttributeValues($product, $request->attribute_values);
            if ($this->isDuplicateVariation($product, $attributeValues)) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => 'Unable to create variation: A variation with identical attributes already exists for this product.',
                        'alert-type' => 'error'
                    ])
                    ->withInput();
            }

            $data = $this->prepareVariationData($request, $product);
            $product->variations()->create($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with([
                    'message' => 'Product variation has been created successfully! You can now manage it from the variations list.',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function edit(Product $product, ProductVariation $variation)
    {
        $attributesWithValues = $this->getProductAttributes($product);

        if (empty($attributesWithValues)) {
            return redirect()->route('admin.products.variations.index', $product)
                ->with([
                    'message' => 'Unable to edit variation: No attributes are configured for this product. Please add attributes first.',
                    'alert-type' => 'error'
                ]);
        }

        foreach ($attributesWithValues as &$attribute) {
            $attribute['selected'] = $variation->attribute_values[$attribute['name']] ?? null;
        }

        return view('admin.product.variation.edit_variation', compact('product', 'variation', 'attributesWithValues'));
    }

    public function update(Request $request, Product $product, ProductVariation $variation)
    {
        try {
            $this->validateProductAttributes($product);
            $this->validateRequest($request, $product, $variation);

            // Format the new attribute values
            $attributeValues = $this->formatAttributeValues($product, $request->attribute_values);

            // Check if this would create a duplicate variation (excluding current variation)
            if ($this->isDuplicateVariationExcludingCurrent($product, $attributeValues, $variation->id)) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => 'Unable to update variation: Another variation with these exact attributes already exists.',
                        'alert-type' => 'error'
                    ])
                    ->withInput();
            }

            $data = $this->prepareVariationData($request, $product, $variation);
            $variation->update($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with([
                    'message' => 'Product variation has been updated successfully! All changes have been saved.',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(Product $product, ProductVariation $variation)
    {
        try {
            $this->deleteImage($variation->variation_image);
            $variation->delete();

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with([
                    'message' => 'Product variation has been deleted successfully.',
                    'alert-type' => 'success'
                ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function getProductAttributes(Product $product): array
    {
        return $product->productAttributes()
            ->with('attribute')
            ->whereNotNull('values')
            ->get()
            ->map(function ($productAttribute) {
                $attribute = $productAttribute->attribute;
                if (!$attribute || empty($productAttribute->values)) {
                    return null;
                }

                $values = $attribute->attribute_type === 'color'
                    ? array_map([$this, 'validateColorValue'], $productAttribute->values)
                    : $productAttribute->values;

                return [
                    'id' => $attribute->id,
                    'name' => $attribute->attribute_name,
                    'type' => $attribute->attribute_type,
                    'values' => $values
                ];
            })
            ->filter()
            ->toArray();
    }

    public function validateColorValue(string $color): string
    {
        $color = strtolower(trim($color));

        return $this->namedColors[$color]
            ?? $this->validateHexColor($color)
            ?? $this->validateRgbColor($color)
            ?? '#000000';
    }

    public function validateHexColor(string $color): ?string
    {
        return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color) ? $color : null;
    }

    public function validateRgbColor(string $color): ?string
    {
        if (!preg_match('/^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/', $color, $matches)) {
            return null;
        }

        return sprintf("#%02x%02x%02x", $matches[1], $matches[2], $matches[3]);
    }

    public function prepareVariationData(Request $request, Product $product, ?ProductVariation $variation = null): array
    {
        $data = $request->except('variation_image');
        $data['attribute_values'] = $this->formatAttributeValues($product, $request->attribute_values);

        if ($request->hasFile('variation_image')) {
            $data['variation_image'] = $this->handleImageUpload($request->file('variation_image'), $variation?->variation_image);
        }

        return $data;
    }

    public function formatAttributeValues(Product $product, array $attributeValues): array
    {
        return collect($attributeValues)->map(function ($value, $name) use ($product) {
            $attribute = $product->productAttributes()
                ->whereHas('attribute', fn($q) => $q->where('attribute_name', $name))
                ->first()?->attribute;

            if ($attribute?->attribute_type === 'color') {
                return $this->validateColorValue($value);
            }

            return $value;
        })->toArray();
    }

    public function handleImageUpload($image, ?string $oldImage = null): string
    {
        try {
            $this->ensureUploadDirectoryExists();

            // First attempt to delete the old image if it exists
            if ($oldImage) {
                $this->deleteImage($oldImage);
            }

            $manager = new ImageManager(new Driver());
            $imageName = uniqid() . '.webp';
            $path = 'upload/variation_images/' . $imageName;

            $manager->read($image)
                ->cover(800, 800)
                ->toWebp(85)
                ->save(public_path($path));

            return $path;
        } catch (\Exception $e) {
            // If something goes wrong, keep the old image
            if ($oldImage && file_exists(public_path($oldImage))) {
                return $oldImage;
            }
            throw $e;
        }
    }

    protected function validateRequest(Request $request, Product $product, ?ProductVariation $variation = null): array
    {
        $rules = [
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'attribute_values' => 'array',
            'variation_image' => [
                $variation ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120'
            ]
        ];

        // Make all attribute fields optional
        foreach ($this->getProductAttributes($product) as $attribute) {
            $attributeName = "attribute_values.{$attribute['name']}";
            if (!empty($attribute['values'])) {
                $rules[$attributeName] = [
                    'nullable',
                    'in:' . implode(',', $attribute['values'])
                ];
            }
        }

        $messages = [
            'variation_image.required' => 'The product variation image is required.',
            'variation_image.max' => 'The image must not be larger than 5MB.',
            'discount_price.lt' => 'The discount price must be less than the regular price.'
        ];

        return $request->validate($rules, $messages);
    }

    public function validateProductAttributes(Product $product): void
    {
        if ($product->activeProductAttributes()->doesntExist()) {
            redirect()
                ->back()
                ->with([
                    'message' => 'Unable to proceed: This product has no active attributes. Please configure product attributes before managing variations.',
                    'alert-type' => 'error'
                ])
                ->throwResponse();
        }
    }

    public function ensureUploadDirectoryExists(): void
    {
        $path = public_path('upload/variation_images');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function deleteImage(?string $image): void
    {
        if ($image && file_exists(public_path($image))) {
            try {
                unlink(public_path($image));
            } catch (\Exception $e) {
                // Silently continue if image deletion fails
            }
        }
    }

    public function handleException(\Exception $e)
    {
        return redirect()
            ->back()
            ->with([
                'message' => 'An error occurred while processing your request. Please try again or contact support if the problem persists.',
                'alert-type' => 'error'
            ])
            ->withInput();
    }

    protected function isDuplicateVariation(Product $product, array $attributeValues): bool
    {
        // Get all existing variations for this product
        $existingVariations = $product->variations()->get();

        // Check if any existing variation has the same attribute values combination
        foreach ($existingVariations as $variation) {
            // Only check for exact matches across all attributes
            $existingAttrs = $variation->attribute_values;
            if (
                empty(array_diff_assoc($existingAttrs, $attributeValues)) &&
                empty(array_diff_assoc($attributeValues, $existingAttrs))
            ) {
                return true; // Found a duplicate
            }
        }

        return false;
    }

    protected function isDuplicateVariationExcludingCurrent(Product $product, array $attributeValues, int $currentVariationId): bool
    {
        // Get all existing variations for this product except the current one
        $existingVariations = $product->variations()->where('id', '!=', $currentVariationId)->get();

        // Check if any existing variation has the same attribute values combination
        foreach ($existingVariations as $variation) {
            $existingAttrs = $variation->attribute_values;
            if (
                empty(array_diff_assoc($existingAttrs, $attributeValues)) &&
                empty(array_diff_assoc($attributeValues, $existingAttrs))
            ) {
                return true; // Found a duplicate
            }
        }

        return false;
    }
}
