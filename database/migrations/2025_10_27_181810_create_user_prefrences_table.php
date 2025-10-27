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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('theme')->default('light'); // 'light' | 'dark' | 'auto'
            $table->string('layout')->default('sidebar'); // 'sidebar' | 'topbar' | 'compact'
            $table->string('language')->default('en');
            $table->json('widgets')->nullable(); // store user widget config (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_prefrences');
    }
};
