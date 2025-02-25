<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'gallery_images' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
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
        return $this->belongsTo(SubCategory::class);
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
