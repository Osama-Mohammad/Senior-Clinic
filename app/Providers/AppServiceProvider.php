<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Cache\RateLimiter;
use App\Observers\AppointmentObserver;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;

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
        Appointment::observe(AppointmentObserver::class);

        $this->app->make(RateLimiter::class)->for('custom-user-limit', function (Request $request) {
            return Limit::perMinute(10)->by(
                optional($request->user('patient'))->id ?: $request->ip()
            );
        });

        // add a guest limiter keyed by IP only
        $this->app->make(RateLimiter::class)->for('guest', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });
    }
}
