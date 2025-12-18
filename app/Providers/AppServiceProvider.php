<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        Vite::prefetch(concurrency: 3);

        // Форсируем HTTPS всегда и везде
        URL::forceScheme('https');

        // Добавляем логирование сессии для отладки
        if (request()->path() === 'login' && request()->isMethod('post')) {
            \Illuminate\Support\Facades\Log::info('Login attempt', [
                'session_id' => session()->getId(),
                'ip' => request()->ip(),
                'headers' => request()->headers->all(),
            ]);
        }
    }
}
