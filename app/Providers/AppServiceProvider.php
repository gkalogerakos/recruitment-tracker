<?php

namespace App\Providers;

use App\Services\CandidateService;
use App\Services\Interfaces\CandidateServiceInterface;
use App\Services\Interfaces\StatusServiceInterface;
use App\Services\Interfaces\StepServiceInterface;
use App\Services\Interfaces\TimelineServiceInterface;
use App\Services\StatusService;
use App\Services\StepService;
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
        $this->app->bind(StepServiceInterface::class, StepService::class);
        $this->app->bind(StatusServiceInterface::class, StatusService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
