<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductVariationController extends Controller
{
    public function index(Product $product)
    {
        $variations = $product->variations()->with('product')->get();
        return view('admin.product.variation.index', compact('product', 'variations'));
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

    public function store(Request $request, Product $product)
    {
        try {
            $this->validateProductAttributes($product);
            $this->validateRequest($request, $product);

            $data = $this->prepareVariationData($request, $product);
            $product->variations()->create($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with('success', 'Variation created successfully');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function edit(Product $product, ProductVariation $variation)
    {
        $attributesWithValues = $this->getProductAttributes($product);

        if (empty($attributesWithValues)) {
            return redirect()->route('admin.products.variations.index', $product)
                ->with('error', 'No attributes found for this product.');
        }

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

            $data = $this->prepareVariationData($request, $product, $variation);
            $variation->update($data);

            return redirect()
                ->route('admin.products.variations.index', $product)
                ->with('success', 'Variation updated successfully');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(Product $product, ProductVariation $variation)
    {
        $this->deleteImage($variation->variation_image);
        $variation->delete();

        return redirect()
            ->route('admin.products.variations.index', $product)
            ->with('success', 'Variation deleted successfully');
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

    public function validateRequest(Request $request, Product $product, ?ProductVariation $variation = null): array
    {
        $rules = [
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'attribute_values' => 'required|array',
            'variation_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'
        ];

        $product->activeProductAttributes()
            ->with('attribute')
            ->get()
            ->each(function ($productAttribute) use (&$rules) {
                if ($productAttribute->attribute && !empty($productAttribute->values)) {
                    $rules["attribute_values.{$productAttribute->attribute->attribute_name}"] = [
                        'required',
                        'in:' . implode(',', $productAttribute->values)
                    ];
                }
            });

        return $request->validate($rules, [
            'sale_price.lt' => 'Sale price must be less than the regular price.'
        ]);
    }

    public function validateProductAttributes(Product $product): void
    {
        if ($product->activeProductAttributes()->doesntExist()) {
            redirect()
                ->back()
                ->with('error', 'This product has no configured attributes. Please add attributes before creating variations.')
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
                // Log error but don't throw to prevent disrupting the main flow
                Log::error("Failed to delete image: {$image}", ['error' => $e->getMessage()]);
            }
        }
    }

    public function handleException(\Exception $e)
    {
        return redirect()
            ->back()
            ->with('error', $e->getMessage())
            ->withInput();
    }
}
