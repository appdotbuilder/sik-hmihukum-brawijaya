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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_induk_kader')->nullable()->unique()->comment('Nomor Induk Kader HMI');
            $table->enum('role', ['administrator', 'pengurus', 'kader'])->default('kader')->comment('User role level');
            $table->enum('status', ['pending', 'verified', 'inactive'])->default('pending')->comment('Account verification status');
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('angkatan')->nullable()->comment('Tahun angkatan');
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->boolean('profile_completed')->default(false)->comment('Profile completion status');
            
            $table->index('role');
            $table->index('status');
            $table->index(['role', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['status']);
            $table->dropIndex(['role']);
            $table->dropColumn([
                'nomor_induk_kader',
                'role',
                'status',
                'phone',
                'birth_date',
                'address',
                'angkatan',
                'fakultas',
                'jurusan',
                'profile_completed'
            ]);
        });
    }
};