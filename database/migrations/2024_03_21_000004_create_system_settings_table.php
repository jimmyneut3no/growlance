<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value');
            $table->string('group');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert default referral settings
        DB::table('system_settings')->insert([
            [
                'key' => 'level_1_percentage',
                'value' => 5,
                'group' => 'referral',
                'description' => 'Level 1 referral percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'level_2_percentage',
                'value' => 3,
                'group' => 'referral',
                'description' => 'Level 2 referral percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'level_3_percentage',
                'value' => 1,
                'group' => 'referral',
                'description' => 'Level 3 referral percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
}; 