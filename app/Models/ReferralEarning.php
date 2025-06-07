<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralEarning extends Model
{
    protected $fillable = [
        'user_id',
        'referrer_id',
        'amount',
        'level',
        'status',
        'source_type',
        'source_id',
    ];

    protected $casts = [
        'amount' => 'decimal:6',
        'level' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function source()
    {
        return $this->morphTo();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeByLevel($query, int $level)
    {
        return $query->where('level', $level);
    }

    public function markAsPaid(): void
    {
        $this->update(['status' => 'paid']);
    }

    public function getTotalEarnings(): float
    {
        return static::where('referrer_id', $this->referrer_id)
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function getPendingEarnings(): float
    {
        return static::where('referrer_id', $this->referrer_id)
            ->where('status', 'pending')
            ->sum('amount');
    }
} 