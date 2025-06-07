<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_stakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('staking_plan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 18, 6);
            $table->decimal('apy', 8, 2);
            $table->decimal('daily_reward', 18, 6);
            $table->decimal('total_reward', 18, 6)->default(0);
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->timestamp('last_reward_at')->nullable();
            $table->string('status')->default('active'); // active, completed, early_unstaked
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_stakes');
    }
}; 