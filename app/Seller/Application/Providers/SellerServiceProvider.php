<?php

namespace App\Seller\Application\Providers;

use App\Seller\Domain\SellerRepository;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerRepository as EloquentSellerRepository;
use Illuminate\Support\ServiceProvider;

class SellerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SellerRepository::class, EloquentSellerRepository::class);
    }
}
