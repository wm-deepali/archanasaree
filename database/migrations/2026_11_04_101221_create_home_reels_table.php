<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_reels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('thumbnail');                   // cover image
            $table->string('video')->nullable();           // uploaded mp4
            $table->string('video_url')->nullable();       // or an external link
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['status', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_reels');
    }
};