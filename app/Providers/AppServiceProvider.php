<?php

namespace App\Providers;

use App\Http\Interfaces\CarInterface;
use App\Http\Interfaces\PaymentInterface;
use App\Http\Interfaces\UserInterface;
use App\Http\Interfaces\WorkInterface;
use App\Http\Repositories\CarRepository;
use App\Http\Repositories\PaymentRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\WorkRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(CarInterface::class, CarRepository::class);
        $this->app->singleton(WorkInterface::class, WorkRepository::class);
        $this->app->singleton(PaymentInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
