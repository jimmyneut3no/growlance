<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $transactions = auth()->check()
        ? auth()->user()->walletTransactions()->latest()->take(5)->get()
        : collect(); // empty if not logged in
    $view->with('notificationData', $transactions);
});
    }
}
