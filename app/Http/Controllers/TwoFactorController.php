<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TwoFactorController extends Controller
{
    protected $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    public function index()
    {
        return view('two-factor.index');
    }
public function showVerifyForm()
    {
        return view('auth.2fa'); // you’ll create this blade file
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $user = User::find(session('2fa:user:id'));

        if (!$user || !$user->two_factor_secret) {
            return redirect()->route('login')->withErrors(['2fa' => 'Invalid session.']);
        }

        $valid = $this->google2fa->verifyKey($user->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        // Log them in now that 2FA is passed
        Auth::login($user);
        session()->forget('2fa:user:id');

        return redirect()->intended(route('dashboard', absolute: false));
    }
    public function enable(Request $request)
    {
        $secretKey = $this->google2fa->generateSecretKey();
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            config('app.name'),
            $request->user()->email,
            $secretKey
        );
        $qrCodeUrl = QrCode::size(200)->generate($qrCodeUrl);
        Session::put('2fa_secret', $secretKey);

        return view('two-factor.enable', [
            'secretKey' => $secretKey,
            'qrCodeUrl' => $qrCodeUrl
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $secretKey = Session::get('2fa_secret');
        $valid = $this->google2fa->verifyKey($secretKey, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        $request->user()->update([
            'two_factor_secret' => $secretKey,
            'two_factor_enabled' => true
        ]);

        Session::forget('2fa_secret');

        return redirect()->route('profile.index')
            ->with('status', 'Two-factor authentication has been enabled.');
    }

    public function disable(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $valid = $this->google2fa->verifyKey(
            $request->user()->two_factor_secret,
            $request->code
        );

        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        $request->user()->update([
            'two_factor_secret' => null,
            'two_factor_enabled' => false
        ]);

        return redirect()->route('profile.index')
            ->with('status', 'Two-factor authentication has been disabled.');
    }
} 