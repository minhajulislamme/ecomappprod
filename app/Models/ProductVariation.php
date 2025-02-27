<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $guarded = [];
    protected $casts = [
        'attribute_values' => 'array',
        'price' => 'integer',
        'discount_price' => 'integer',
        'stock' => 'integer',
        'status' => 'string'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function formatColorValue($color)
    {
        if (empty($color)) return null;
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) return $color;
        if (preg_match('/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/', $color, $m)) {
            return sprintf("#%02x%02x%02x", $m[1], $m[2], $m[3]);
        }
        return $color;
    }
}
