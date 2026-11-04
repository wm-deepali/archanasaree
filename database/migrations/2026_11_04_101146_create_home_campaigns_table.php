<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');                       // new lines become <br>
            $table->text('description')->nullable();

            $table->string('primary_btn_text')->nullable();
            $table->string('primary_btn_link')->nullable();
            $table->string('secondary_btn_text')->nullable();
            $table->string('secondary_btn_link')->nullable();

            $table->text('highlights')->nullable();        // one bullet per line
            $table->string('bg_image')->nullable();
            $table->string('image')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_campaigns');
    }
};