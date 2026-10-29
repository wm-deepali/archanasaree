<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {

          
        });
    }

    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {

            $table->dropUnique([
                'customer_id',
                'product_id'
            ]);

            $table->dropConstrainedForeignId('customer_id');
        });
    }
};