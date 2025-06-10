<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\StakingController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\CredentialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class,'home'])->name('home');

Route::get('/staking-plans', [PagesController::class,'stakingPlans'])->name('staking-plans');

Route::get('/contact', [PagesController::class,'contact'])->name('contact');

Route::get('/terms-conditions', function () {
    return view('terms');
})->name('terms-conditions');

Route::get('/privacy-policy', function () {
    return view('policy');
})->name('privacy-policy');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['sweep']);
    Route::get('/announcements', [DashboardController::class, 'announcements'])->name('announcements');

    // Staking
    Route::get('/staking', [StakingController::class, 'index'])->name('staking.index');
    Route::post('/staking/{plan}', [StakingController::class, 'stake'])->name('staking.stake');
    Route::post('/staking/{stake}/unstake', [StakingController::class, 'unstake'])->name('staking.unstake');
    Route::get('/staking/plans', [StakingController::class, 'plans'])->name('staking.plans');
    Route::get('/staking/history', [StakingController::class, 'history'])->name('staking.history');

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index')->middleware(['sweep']);
    Route::get('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');
    Route::get('/wallet/withdraw', [WalletController::class, 'viewWithdrawal'])->name('wallet.view.withdraw')->middleware(['sweep']);
    Route::get('/wallet/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions')->middleware(['sweep']);

    // Referral
    Route::get('/referral', [ReferralController::class, 'index'])->name('referral.index');
    Route::post('/referral/withdraw', [ReferralController::class, 'withdraw'])->name('referral.withdraw');
    Route::get('/referral/statistics', [ReferralController::class, 'statistics'])->name('referral.statistics');
    Route::get('/referral/referrals', [ReferralController::class, 'referrals'])->name('referral.referrals');
    Route::get('/referral/earnings', [ReferralController::class, 'earnings'])->name('referral.earnings');

    // Support
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
    Route::get('/support/search', [SupportController::class, 'index'])->name('support.search');
    Route::get('/support/create', [SupportController::class, 'create'])->name('support.ticket.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [SupportController::class, 'show'])->name('support.show');
    Route::post('/support/{ticket}/reply', [SupportController::class, 'reply'])->name('support.reply');
    Route::post('/support/{ticket}/close', [SupportController::class, 'close'])->name('support.close');
    Route::post('/support/{ticket}/reopen', [SupportController::class, 'reopen'])->name('support.reopen');
    Route::get('/support/categories', [SupportController::class, 'categories'])->name('support.categories');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware(['sweep']);
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/profile/advanced', [ProfileController::class, 'advanced'])->name('profile.advanced');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Two Factor Authentication Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
    Route::any('/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::post('/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
});

// Webhook endpoint for blockchain operations
Route::post('/webhook/wallet', [WalletController::class, 'webhook'])->name('webhook.wallet');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/view-password', [ProfileController::class, 'viewPasswordAdmin'])->name('view-password');
    Route::post('/change-password', [App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('change-password');
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle-admin', [App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::post('/users/{user}/update-kyc', [App\Http\Controllers\Admin\UserController::class, 'updateKycStatus'])->name('users.update-kyc');
    
    // Staking Plans
    Route::resource('staking-plans', App\Http\Controllers\Admin\StakingPlanController::class);
    Route::post('/staking-plans/{stakingPlan}/toggle-active', [App\Http\Controllers\Admin\StakingPlanController::class, 'toggleActive'])->name('staking-plans.toggle-active');
    
    // Referral Settings
    Route::get('/referral-settings', [App\Http\Controllers\Admin\ReferralSettingsController::class, 'index'])->name('referral-settings.index');
    Route::put('/referral-settings', [App\Http\Controllers\Admin\ReferralSettingsController::class, 'update'])->name('referral-settings.update');

    Route::resource('credentials', CredentialController::class)->only(['index', 'store', 'update']);
    Route::get('/credentials/health', [CredentialController::class, 'health'])->name('credentials.health');
    Route::post('/credentials/restart', [CredentialController::class, 'restartServer'])->name('credentials.restart');
    Route::post('/credentials/sweep-all', [CredentialController::class, 'sweepAll'])->name('credentials.sweep-all');
});

require __DIR__.'/auth.php';
