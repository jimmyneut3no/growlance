<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ReferralSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::where('group', 'referral')->get()
            ->pluck('value', 'key')
            ->toArray();

        return view('admin.referral-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'level_1_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'level_2_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'level_3_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key, 'group' => 'referral'],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Referral settings updated successfully');
    }
} 