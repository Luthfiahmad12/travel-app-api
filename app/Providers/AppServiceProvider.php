<?php

namespace App\Providers;

use App\Repositories\Interfaces\ScheduleRepositoryInterface;
use App\Repositories\ScheduleRepository;
use App\Services\ScheduleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);

        $this->app->bind(ScheduleService::class, function ($app) {
            return new ScheduleService($app->make(ScheduleRepositoryInterface::class));
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
