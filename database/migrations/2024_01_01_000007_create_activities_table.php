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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Activity name');
            $table->text('description')->nullable();
            $table->date('date')->comment('Activity date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->enum('participant_type', ['all_kader', 'pengurus', 'selected'])->default('all_kader')
                  ->comment('Type of participants allowed');
            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('date');
            $table->index('status');
            $table->index('created_by');
            $table->index(['date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};