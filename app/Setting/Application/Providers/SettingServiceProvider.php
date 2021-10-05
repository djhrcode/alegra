<?php

namespace App\Setting\Application\Providers;

use App\Setting\Domain\SettingRepository;
use App\Setting\Infrastructure\Persistence\Eloquent\SettingRepository as EloquentSettingRepository;
use Illuminate\Support\ServiceProvider;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
