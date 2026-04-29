<?php

namespace App\Providers;

use App\Services\ContentModerationService;
use App\Services\GeminiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GeminiService::class, fn() => new GeminiService());

        $this->app->singleton(ContentModerationService::class, fn() => new ContentModerationService(
            apiKey: config('services.gemini.key'),
            apiUrl: config('services.gemini.url'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}