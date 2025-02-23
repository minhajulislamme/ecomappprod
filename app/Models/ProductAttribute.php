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
        // Only process and store non-empty values
        if (!empty($values)) {
            $formattedValues = is_array($values) ? array_filter($values) : [$values];

            // Format color values if this is a color attribute
            if ($this->attribute && $this->attribute->attribute_type === 'color') {
                $formattedValues = array_map(function ($value) {
                    return $this->formatColorValue($value);
                }, $formattedValues);
            }

            $this->attributes['values'] = json_encode(array_values($formattedValues));
        } else {
            $this->attributes['values'] = null;
        }
    }

    public function getValuesAttribute($value)
    {
        $values = json_decode($value, true);

        if (!$values) {
            return [];
        }

        if ($this->attribute && $this->attribute->attribute_type === 'color') {
            return array_map(function ($value) {
                return $this->formatColorValue($value);
            }, $values);
        }

        return $values;
    }

    public function hasValues()
    {
        return !empty($this->values);
    }

    protected function formatColorValue($color)
    {
        if (empty($color)) {
            return null;
        }

        // Already a valid hex color
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
            return $color;
        }

        // Convert RGB format
        if (preg_match('/^rgb\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)$/', $color, $matches)) {
            $r = intval($matches[1]);
            $g = intval($matches[2]);
            $b = intval($matches[3]);
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        }

        // Strip any whitespace and validate
        $color = trim($color);
        if (empty($color)) {
            return null;
        }

        return $color;
    }
}
