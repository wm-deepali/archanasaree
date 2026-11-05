<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 40)->unique();     // about, blogs, contact, faqs
            $table->string('eyebrow')->nullable();
            $table->string('title');                      // new lines become <br>
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('tag')->nullable();            // small label on the image
            $table->string('primary_btn_text')->nullable();
            $table->string('primary_btn_link')->nullable();
            $table->string('secondary_btn_text')->nullable();
            $table->string('secondary_btn_link')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_heroes');
    }
};