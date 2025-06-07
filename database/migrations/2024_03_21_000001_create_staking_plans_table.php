<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staking_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // flexible, 30-day, 90-day
            $table->decimal('apy', 8, 2);
            $table->integer('lock_period')->nullable(); // in days, null for flexible
            $table->decimal('min_stake', 18, 6);
            $table->decimal('max_stake', 18, 6);
            $table->decimal('early_unstake_penalty', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staking_plans');
    }
}; 