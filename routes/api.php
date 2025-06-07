<?php

use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

// Webhook endpoint for blockchain operations
Route::post('/webhook', [WalletController::class, 'webhook'])->name('webhook.wallet');

require __DIR__.'/auth.php';
