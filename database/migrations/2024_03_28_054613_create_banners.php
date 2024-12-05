<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('banners_categories')->cascadeOnDelete();
            $table->text('name')->nullable();
            $table->string('image')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->timestamps();
            $table->tinyInteger('published')->nullable();
            $table->tinyInteger('ordering')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};