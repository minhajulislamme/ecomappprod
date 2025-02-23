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

    // Relationships
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

    public function activeProductAttributes()
    {
        return $this->hasMany(ProductAttribute::class)->whereNotNull('values');
    }

    public function hasConfiguredAttributes()
    {
        return $this->productAttributes()->whereNotNull('values')->exists();
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function hasVariations()
    {
        return $this->variations()->count() > 0;
    }
}
