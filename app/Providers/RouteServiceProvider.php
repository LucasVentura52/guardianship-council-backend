<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public function boot(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));
        RateLimiter::for('login', fn (Request $request) => Limit::perMinute(5)->by('login|'.$request->ip()));
        RateLimiter::for('sugestoes', fn (Request $request) => Limit::perMinute(10)->by('sugestoes|'.$request->ip()));
        RateLimiter::for('contato', fn (Request $request) => Limit::perMinute(10)->by('contato|'.$request->ip()));
        RateLimiter::for('esqueci-senha', fn (Request $request) => Limit::perMinute(3)->by('esqueci-senha|'.$request->ip()));
        RateLimiter::for('redefinir-senha', fn (Request $request) => Limit::perMinute(5)->by('redefinir-senha|'.$request->ip()));
        RateLimiter::for('alterar-senha', fn (Request $request) => Limit::perMinute(5)->by('alterar-senha|'.($request->user()?->id ?: $request->ip())));
        RateLimiter::for('visitas', fn (Request $request) => Limit::perMinute(120)->by('visitas|'.$request->ip()));

        $this->routes(function () {
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));
            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }
}
