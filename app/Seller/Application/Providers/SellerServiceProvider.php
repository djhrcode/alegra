<?php

namespace App\Seller\Application\Providers;

use App\Seller\Domain\SellerRepository;
use App\Seller\Domain\ValueObjects\SellerWinningPoints;
use App\Seller\Infrastructure\Persistence\Eloquent\SellerRepository as EloquentSellerRepository;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
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


        $this->app->singleton(SellerWinningPoints::class, function () {
            $settings = app(SettingRepository::class);
            $settingName = SettingName::fromValue(SettingName::CONTEST_WINNING_POINTS);

            return SellerWinningPoints::fromValue(
                (int) $settings->find($settingName)?->value()?->value() ?? 20
            );
        });
    }
}
