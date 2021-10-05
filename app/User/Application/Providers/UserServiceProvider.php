<?php

namespace App\User\Infrastructure\Providers;

use App\User\Domain\UserRepository;
use App\User\Infrastructure\Persistence\Eloquent\UserRepository as EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
    }
}
