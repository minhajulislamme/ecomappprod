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
        'gallery_images' => 'array',
        'price' => 'decimal:2',
        'stock' => 'integer',
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

    // Relationships with eager loading defaults
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class)->withDefault();
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class)
            ->with('attribute:id,attribute_name,attribute_type');
    }

    public function activeProductAttributes()
    {
        return $this->productAttributes()
            ->whereNotNull('values')
            ->with('attribute:id,attribute_name,attribute_type');
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    // Optimized helper methods
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
