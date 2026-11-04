<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_sliders', function (Blueprint $table) {
            $table->id();

            $table->string('image');                       // banner image (storage path)

            $table->string('eyebrow')->nullable();         // small text above the title
            $table->string('title')->nullable();           // new line in the textarea = <br>
            $table->text('description')->nullable();

            $table->string('primary_btn_text')->nullable();
            $table->string('primary_btn_link')->nullable();

            $table->string('secondary_btn_text')->nullable();
            $table->string('secondary_btn_link')->nullable();

            $table->string('note')->nullable();            // small line under the buttons

            $table->string('theme', 20)->default('default'); // default | white
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sliders');
    }
};