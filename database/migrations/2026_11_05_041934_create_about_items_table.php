<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('about_items', function (Blueprint $table) {
            $table->id();
            $table->string('section_key', 40);
            $table->string('group_key', 30)->default('list');   // stats, cards, list, tags ...
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon', 60)->nullable();              // e.g. fa-gem
            $table->string('value', 40)->nullable();             // e.g. 25+
            $table->string('link')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['section_key', 'group_key', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_items');
    }
};