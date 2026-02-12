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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('genre')->nullable();
            $table->string('format')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->unsignedSmallInteger('published_year')->nullable();
            $table->decimal('rating', 3, 1)->default(0);
            $table->text('blurb')->nullable();
            $table->string('cover_tone')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_deal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
