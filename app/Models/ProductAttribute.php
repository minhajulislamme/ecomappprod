<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = [];

    protected $casts = [
        'values' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function setValuesAttribute($values)
    {
        $formattedValues = array_filter(is_array($values) ? $values : [$values]);

        if ($this->attribute?->attribute_type === 'color') {
            $formattedValues = array_map([$this, 'formatColorValue'], $formattedValues);
        }

        $this->attributes['values'] = !empty($formattedValues) ?
            json_encode(array_values($formattedValues)) : null;
    }

    public function getValuesAttribute($value)
    {
        $values = json_decode($value, true) ?? [];

        return $this->attribute?->attribute_type === 'color'
            ? array_map([$this, 'formatColorValue'], $values)
            : $values;
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
}
