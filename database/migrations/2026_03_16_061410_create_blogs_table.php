<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('author')->nullable();
            $table->string('tags')->nullable();    
            $table->date('published_at')->nullable();
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('show_home')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(1);
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};