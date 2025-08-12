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
            $table->string('title')->comment('Book title');
            $table->string('author')->comment('Book author');
            $table->text('description')->nullable();
            $table->enum('type', ['physical', 'digital'])->comment('Book type: physical or digital');
            $table->string('isbn')->nullable()->unique();
            $table->integer('stock')->default(0)->comment('Available copies for physical books');
            $table->string('file_path')->nullable()->comment('File path for digital books');
            $table->string('cover_image')->nullable();
            $table->enum('category', ['textbook', 'reference', 'research', 'islamic', 'law', 'general'])->default('general');
            $table->enum('status', ['available', 'maintenance', 'unavailable'])->default('available');
            $table->timestamps();
            
            $table->index('type');
            $table->index('category');
            $table->index('status');
            $table->index(['type', 'status']);
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