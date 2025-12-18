<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

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

        // Принудительный HTTPS для всех ссылок и ресурсов
        URL::forceScheme('https');

        // Фикс для 419: заставляем Laravel думать, что мы всегда на правильном домене
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            Config::set('sanctum.stateful', [
                'localhost:8080',
                '127.0.0.1:8080',
                $_SERVER['HTTP_X_FORWARDED_HOST'],
                parse_url(config('app.url'), PHP_URL_HOST)
            ]);
        }
    }
}
