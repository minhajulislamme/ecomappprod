<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->string('thumbnail_image');
            $table->json('gallery_images')->nullable();
            $table->integer('stock')->default(0);
            $table->enum('is_featured', ['yes', 'no'])->default('no');
            $table->enum('is_trending', ['yes', 'no'])->default('no');
            $table->enum('is_best_selling', ['yes', 'no'])->default('no');
            $table->enum('is_offer', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->index(['category_id', 'subcategory_id']);
            $table->index(['is_featured', 'status']);
            $table->index(['is_trending', 'status']);
            $table->index(['is_best_selling', 'status']);
            $table->index('price');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
