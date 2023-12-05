<?php

namespace App\Providers;

use App\Logic\Content\NewsSources\GuardianAPISource;
use App\Logic\Content\NewsSources\NewsAPISource;
use App\Logic\Service\Contracts\NewsServiceInterface;
use App\Logic\Service\Contracts\SourceServiceInterface;
use App\Logic\Service\Contracts\UserPreferenceServiceInterface;
use App\Logic\Service\NewsService;
use App\Logic\Service\SourceService;
use App\Logic\Service\UserPreferenceService;
use App\Logic\Utility\EndPointFetcher;
use App\Logic\Utility\NewsFetcherUtility;
use App\Repositories\News\EloquentNewsRepository;
use App\Repositories\News\NewsRepository;
use App\Repositories\Source\EloquentSourcesRepository;
use App\Repositories\User\EloquentUserPreferenceRepository;
use App\Repositories\User\UserPreferenceRepository;
use Illuminate\Support\ServiceProvider;

class AppLayersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindInterfaces();

        $this->injectDependencies();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * @return void
     */
    private function bindInterfaces(): void
    {
        $this->app->bind(
            NewsRepository::class,
            EloquentNewsRepository::class
        );

        $this->app->bind(
            SourceRepository::class,
            EloquentSourcesRepository::class
        );

        $this->app->bind(
            UserPreferenceRepository::class,
            EloquentUserPreferenceRepository::class
        );

        $this->app->bind(
            NewsServiceInterface::class,
            NewsService::class,
        );

        $this->app->bind(
            SourceServiceInterface::class,
            SourceService::class,
        );

        $this->app->bind(
            UserPreferenceServiceInterface::class,
            UserPreferenceService::class,
        );

        $this->app->bind(
            EndPointFetcher::class,
            NewsFetcherUtility::class
        );
    }

    /**
     * @return void
     */
    private function injectDependencies(): void
    {
        $this->app->bind('NewsService', function () {
            return new \App\Logic\Service\NewsService(app('App\Repositories\News\NewsRepository'));
        });

        $this->app->bind('SourceService', function () {
            return new \App\Logic\Service\SourceService(app('App\Repositories\Source\SourceRepository'));
        });

        $this->app->bind('UserPreferenceService', function () {
            return new \App\Logic\Service\UserPreferenceService(app('App\Repositories\User\UserPreferenceRepository'));
        });

        $this->app->bind(
            'NewsAPISource',
            function () {
                $class = new NewsFetcherUtility('https://newsapi.org/v2/');
                return new NewsAPISource($class);
            }
        );

        $this->app->bind(
            'GuardianAPISource',
            function () {
                $class = new NewsFetcherUtility('https://content.guardianapis.com/');
                return new GuardianAPISource($class);
            }
        );
    }
}
