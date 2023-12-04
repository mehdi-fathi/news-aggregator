<?php

namespace App\Providers;

use App\Logic\Content\NewsSources\GuardianAPISource;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Logic\Utility\EndPointFetcher;
use App\Logic\Utility\NewsFetcherUtility;
use App\Repositories\News\EloquentNewsRepository;
use App\Repositories\News\NewsRepository;
use App\Repositories\Source\EloquentSourcesRepository;
use App\Repositories\Source\SourceRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            NewsRepository::class,
            EloquentNewsRepository::class

        );

        $this->app->bind(
            SourceRepository::class,
            EloquentSourcesRepository::class

        );

        $this->app->bind('NewsService', function () {
            return new \App\Logic\Service\NewsService(app('App\Repositories\News\NewsRepository'));
        });

        $this->app->bind('SourceService', function () {
            return new \App\Logic\Service\SourceService(app('App\Repositories\Source\SourceRepository'));
        });

        $this->app->bind(
            EndPointFetcher::class,
            NewsFetcherUtility::class
        );

        $this->app->bind(
            'NewsAPISource'
            , function () {
            $class = new NewsFetcherUtility('https://newsapi.org/v2/');
            return new NewsAPISource($class);
        }
        );

        $this->app->bind(
            'GuardianAPISource'
            , function () {
            $class = new NewsFetcherUtility('https://content.guardianapis.com/');
            return new GuardianAPISource($class);
        }
        );


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
