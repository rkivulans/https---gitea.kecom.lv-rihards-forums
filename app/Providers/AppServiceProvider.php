<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Izlogojam bloķētos lietotājus
        \Illuminate\Support\Facades\Event::listen('Illuminate\Auth\Events\Authenticated', function ($event) {
            if (Auth::check() && Auth::user()->blocked_users === 'block') {
                Auth::logout();
                session()->flash('error', 'Your account is blocked.');
                redirect()->route('login')->send();
            }
        });
    }
}
