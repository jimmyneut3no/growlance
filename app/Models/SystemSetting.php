<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever('setting.' . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function set(string $key, $value, string $group = 'general', bool $isPublic = false): void
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'is_public' => $isPublic,
            ]
        );

        Cache::forget('setting.' . $key);
    }

    public static function getGroup(string $group): array
    {
        return Cache::rememberForever('settings.group.' . $group, function () use ($group) {
            return static::where('group', $group)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function clearCache(): void
    {
        Cache::tags(['settings'])->flush();
    }

    public static function getPublicSettings(): array
    {
        return Cache::rememberForever('settings.public', function () {
            return static::where('is_public', true)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public static function getReferralPercentages(): array
    {
        $settings = static::where('group', 'referral')
            ->whereIn('key', ['level_1_percentage', 'level_2_percentage', 'level_3_percentage'])
            ->pluck('value', 'key')
            ->toArray();

        return [
            1 => $settings['level_1_percentage'] ?? 5,
            2 => $settings['level_2_percentage'] ?? 3,
            3 => $settings['level_3_percentage'] ?? 1,
        ];
    }
} 