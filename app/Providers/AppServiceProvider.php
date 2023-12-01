<?php

namespace App\Providers;

use App\Repositories\News\EloquentNewsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Repositories\News\NewsRepository',
            EloquentNewsRepository::class

        );

        $this->app->bind('NewsService', function () {
            return new \App\Logic\Service\NewsService(app('App\Repositories\News\NewsRepository'));
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
