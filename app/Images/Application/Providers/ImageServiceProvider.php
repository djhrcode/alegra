<?php

namespace App\Images\Application\Providers;

use App\Images\Domain\ImageRepository;
use App\Images\Infrastructure\Http\Unsplash\ImageRepository as UnsplashImageRepository;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageRepository::class, UnsplashImageRepository::class);
    }
}
