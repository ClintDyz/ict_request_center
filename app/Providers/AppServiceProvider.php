<?php

namespace App\Providers;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Event::listen(Login::class, function ($event) {
            AuditLog::log('login', 'User logged in', $event->user);
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                AuditLog::log('logout', 'User logged out', $event->user);
            }
        });
    }
}
