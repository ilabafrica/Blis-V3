<?php

namespace App\Providers;

use App\Models\Result;
use App\Observers\ResultObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Set Default length of a string data type
        Schema::defaultStringLength(191);
        Result::observe(ResultObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
