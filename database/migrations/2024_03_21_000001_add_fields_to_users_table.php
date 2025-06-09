<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('referral_code')->unique()->nullable();
            $table->foreignId('referred_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('kyc_status')->default('pending'); // pending, verified, rejected 
            $table->json('kyc_data')->nullable();
            $table->json('two_factor_recovery_codes')->nullable();
            $table->timestamp('last_ticket_read_at')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn([
                'referral_code',
                'referred_by',
                'kyc_status',
                'kyc_data',
                'two_factor_recovery_codes',
                'last_ticket_read_at',
                'is_active'
            ]);
        });
    }
}; 