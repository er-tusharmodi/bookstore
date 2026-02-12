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
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->foreignId('spotlight_book_id')->nullable()->constrained('books')->nullOnDelete();
            $table->json('featured_book_ids')->nullable();
            $table->json('more_book_ids')->nullable();
            $table->json('featured_author_ids')->nullable();
            $table->unsignedInteger('stats_books')->nullable();
            $table->unsignedInteger('stats_authors')->nullable();
            $table->unsignedInteger('stats_genres')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
