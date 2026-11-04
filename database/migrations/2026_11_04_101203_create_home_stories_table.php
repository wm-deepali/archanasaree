<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_stories', function (Blueprint $table) {
            $table->id();

            // Our Story
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('description_2')->nullable();
            $table->string('tag')->nullable();             // "Inspired by Delhi"
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
            $table->string('main_image')->nullable();
            $table->string('small_image')->nullable();

            // Meet the Founder
            $table->string('founder_name')->nullable();
            $table->string('founder_role')->nullable();
            $table->text('founder_message')->nullable();
            $table->string('founder_photo')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_stories');
    }
};