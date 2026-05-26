<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\NotificationComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', NotificationComposer::class);

        View::composer('*', function ($view) {
            if (Auth::guard('staff')->check()) {
                $view->with('staff', Auth::guard('staff')->user()->fresh());
            }
        });
    }
}