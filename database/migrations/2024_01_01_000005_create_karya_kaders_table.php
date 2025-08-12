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
        Schema::create('karya_kaders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->comment('Karya title');
            $table->text('description')->nullable();
            $table->enum('type', ['physical', 'digital'])->comment('Karya type: physical or digital');
            $table->enum('category', ['research', 'article', 'thesis', 'proposal', 'islamic', 'law', 'general'])->default('general');
            $table->string('file_path')->nullable()->comment('File path for digital karya');
            $table->string('cover_image')->nullable();
            $table->integer('stock')->default(0)->comment('Available copies for physical karya');
            $table->enum('status', ['available', 'review', 'unavailable'])->default('review');
            $table->timestamps();
            
            $table->index('user_id');
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
        Schema::dropIfExists('karya_kaders');
    }
};