<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Multiavatar;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'referred_by',
        'kyc_status',
        'kyc_data',
        'two_factor_secret',
        'two_factor_enabled',
        'two_factor_recovery_codes',
        'last_ticket_read_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_enabled',
        'two_factor_recovery_codes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'kyc_data' => 'array',
            'last_ticket_read_at' => 'datetime',
        ];
    }

    public function stakes(): HasMany
    {
        return $this->hasMany(UserStake::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function referralEarnings(): HasMany
    {
        return $this->hasMany(ReferralEarning::class, 'referrer_id');
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function referrer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'referred_by');
    }

    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function getBalance(): float
    {
        return $this->walletTransactions()
            ->where('status', 'completed')
            ->selectRaw("
                SUM(CASE WHEN type IN ('deposit', 'reward', 'unstake', 'referral') THEN amount ELSE 0 END) -
                SUM(CASE WHEN type IN ('withdrawal', 'stake','fee') THEN amount ELSE 0 END) AS balance
            ")
            ->value('balance') ?? 0;
    }

    public function getStakedBalance(): float
    {
        return $this->stakes()
            ->where('status', 'active')
            ->sum('amount');
    }

    public function getTotalEarnings(): float
    {
        return $this->walletTransactions()
            ->where('status', 'completed')
            ->where('type', 'reward')
            ->sum('amount');
    }

    public function getReferralEarnings(): float
    {
        return $this->referralEarnings()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function getPendingReferralEarnings(): float
    {
        return $this->referralEarnings()
            ->where('status', 'pending')
            ->sum('amount');
    }

    public function getReferralLink(): string
    {
        return route('register', ['ref' => $this->username]);
    }

    public function isKycVerified(): bool
    {
        return $this->kyc_status === 'verified';
    }

    public function enableTwoFactor(): void
    {
        $this->two_factor_secret = encrypt(random_bytes(32));
        $this->two_factor_recovery_codes = encrypt(json_encode(
            array_map(fn () => bin2hex(random_bytes(10)), range(1, 8))
        ));
        $this->save();
    }

    public function disableTwoFactor(): void
    {
        $this->two_factor_secret = null;
        $this->two_factor_recovery_codes = null;
        $this->save();
    }

    public function hasTwoFactorEnabled(): bool
    {
        return !is_null($this->two_factor_secret);
    }

    public function stakeRewards()
    {
        return $this->hasMany(StakeReward::class);
    }

    public function getAvatar()
    {
        $multiavatar = new Multiavatar();
        $avatarId = $this->id;
        $svgCode = $multiavatar($avatarId, null, null);
        return $svgCode;
    }

    public function getLevel1Referrals(): HasMany
    {
        return $this->referrals();
    }

    public function getLevel2Referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by')
            ->whereHas('referrals');
    }

    public function getLevel3Referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by')
            ->whereHas('referrals', function ($query) {
                $query->whereHas('referrals');
            });
    }

    public function getTotalReferralsCount(): int
    {
        return $this->getLevel1Referrals()->count() +
               $this->getLevel2Referrals()->count() +
               $this->getLevel3Referrals()->count();
    }

    public function getReferralEarningsByLevel(int $level): float
    {
        return $this->referralEarnings()
            ->where('level', $level)
            ->sum('amount');
    }

    public function getPendingReferralEarningsByLevel(int $level): float
    {
        return $this->referralEarnings()
            ->where('level', $level)
            ->where('status', 'pending')
            ->sum('amount');
    }
}
