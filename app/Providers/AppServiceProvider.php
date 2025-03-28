<?php

namespace App\Providers;

use App\Services\BookingService;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\DoctorServiceInterface;
use App\Services\Contracts\HairstylistServiceInterface;
use App\Services\Contracts\TableServiceInterface;
use App\Services\DoctorService;
use App\Services\HairstylistService;
use App\Services\TableService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DoctorServiceInterface::class, DoctorService::class);
        $this->app->bind(HairstylistServiceInterface::class, HairstylistService::class);
        $this->app->bind(TableServiceInterface::class, TableService::class);
        $this->app->bind(BookingServiceInterface::class, BookingService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
