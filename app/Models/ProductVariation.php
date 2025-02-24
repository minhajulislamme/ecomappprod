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
        $color = trim($color);
        if (empty($color)) return null;

        // Handle hex color
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return $color;
        }

        // Handle RGB format
        if (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $color, $m)) {
            return sprintf("#%02x%02x%02x", $m[1], $m[2], $m[3]);
        }

        return $color;
    }

    public function getAttributeValuesAttribute($value)
    {
        $values = json_decode($value, true) ?? [];

        // Cache attribute types to avoid multiple queries
        $attributeTypes = $this->product->productAttributes()
            ->with('attribute:id,attribute_name,attribute_type')
            ->get()
            ->pluck('attribute.attribute_type', 'attribute.attribute_name')
            ->toArray();

        // Format color values
        foreach ($values as $attribute => $val) {
            if (($attributeTypes[$attribute] ?? null) === 'color') {
                $values[$attribute] = $this->formatColorValue($val);
            }
        }

        return $values;
    }
}
