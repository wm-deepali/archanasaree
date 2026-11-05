<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key', 40)->unique();      // story, who, philosophy ...
            $table->string('eyebrow')->nullable();
            $table->string('title')->nullable();      // new lines become <br>
            $table->text('description')->nullable();
            $table->text('description_2')->nullable();
            $table->text('description_3')->nullable();
            $table->string('btn_text')->nullable();
            $table->string('btn_link')->nullable();
            $table->string('tag')->nullable();
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};