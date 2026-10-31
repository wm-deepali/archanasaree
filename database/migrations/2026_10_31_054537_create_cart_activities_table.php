<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_activities', function (Blueprint $table) {
            $table->id();

            $table->uuid('visitor_id')->index();              // long-lived cookie, login par change nahi hota
            $table->unsignedBigInteger('cart_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();

            $table->string('event', 40)->index();
            $table->decimal('cart_total', 12, 2)->nullable();
            $table->unsignedInteger('items_count')->nullable();

            $table->string('ip_address', 45)->nullable();
            $table->string('device_type', 20)->nullable();    // mobile / tablet / desktop
            $table->string('browser', 60)->nullable();
            $table->string('os', 60)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('country', 80)->nullable();
            $table->string('region', 80)->nullable();
            $table->string('city', 80)->nullable();

            $table->string('referrer', 500)->nullable();
            $table->json('meta')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['visitor_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_activities');
    }
};