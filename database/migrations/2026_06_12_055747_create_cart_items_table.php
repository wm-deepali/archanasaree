<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cart_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('price_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('image_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('stock_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->foreignId('sku_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            $table->json('selected_attributes')->nullable();
            $table->string('custom_colour_code', 50)->nullable();
            $table->decimal('dye_charge', 10, 2)->default(0);
            $table->unsignedInteger('quantity');

            $table->decimal(
                'price',
                12,
                2
            );

            $table->decimal(
                'total',
                12,
                2
            );

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};