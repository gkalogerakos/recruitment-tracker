<?php

namespace App\Providers;

use App\Services\CandidateService;
use App\Services\Interfaces\CandidateServiceInterface;
use App\Services\Interfaces\TimelineServiceInterface;
use App\Services\TimelineService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TimelineServiceInterface::class, TimelineService::class);
        $this->app->bind(CandidateServiceInterface::class, CandidateService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
