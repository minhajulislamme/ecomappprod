<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $guarded = [];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'attribute_values' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected function formatColorValue($color)
    {
        // If it's already a hex color, return it
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return $color;
        }

        // If it's RGB format, convert to hex
        if (preg_match('/^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/', $color, $matches)) {
            $r = intval($matches[1]);
            $g = intval($matches[2]);
            $b = intval($matches[3]);
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        }

        return $color;
    }

    public function getAttributeValuesAttribute($value)
    {
        $values = json_decode($value, true) ?? [];

        // Format any color values
        foreach ($values as $attribute => $val) {
            $attributeType = $this->product->productAttributes()
                ->whereHas('attribute', function ($q) use ($attribute) {
                    $q->where('attribute_name', $attribute);
                })
                ->first()?->attribute?->attribute_type;

            if ($attributeType === 'color') {
                $values[$attribute] = $this->formatColorValue($val);
            }
        }

        return $values;
    }
}
