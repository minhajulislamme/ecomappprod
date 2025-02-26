<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = [];
    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'gallery_images' => 'array',
        'subcategory_id' => 'integer', // Ensures proper conversion to integer or null
    ];

    // Set attributes that can be null
    protected $attributes = [
        'subcategory_id' => null,
        'discount_price' => null,
        'description' => null,
        'short_description' => null,
        'gallery_images' => '[]'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);

            // Ensure subcategory_id is properly set to null if empty
            if (empty($product->subcategory_id)) {
                $product->subcategory_id = null;
            }
        });

        static::deleting(function ($product) {
            $product->variations()->delete();
        });
    }

    // Essential relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class)->withDefault();
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    // Helper methods
    public function activeProductAttributes()
    {
        return $this->productAttributes()->whereNotNull('values');
    }

    public function hasConfiguredAttributes(): bool
    {
        return $this->activeProductAttributes()->exists();
    }

    public function hasVariations(): bool
    {
        return cache()->remember(
            "product_{$this->id}_has_variations",
            now()->addMinutes(60),
            fn() => $this->variations()->exists()
        );
    }
}
