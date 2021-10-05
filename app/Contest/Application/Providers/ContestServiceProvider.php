<?php

namespace App\Contest\Application\Providers;

use App\Contest\Domain\ContestRepository;
use App\Contest\Infrastructure\Persistence\Eloquent\ContestRepository as EloquentContestRepository;
use Illuminate\Support\ServiceProvider;

class ContestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ContestRepository::class, EloquentContestRepository::class);
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
