<?php

namespace App\Setting\Application\Providers;

use App\Setting\Domain\Contest\ContestActiveIdSetting;
use App\Setting\Domain\SettingRepository;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Infrastructure\Persistence\Cache\CacheRepositoryDecorator;
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

        $this->app->extend(
            SettingRepository::class,
            fn ($repository) => $this->app->make(CacheRepositoryDecorator::class, ['repository' => $repository])
        );

        $this->app->singleton(ContestActiveIdSetting::class, function () {
            $settings = app(SettingRepository::class);
            $setting = SettingName::fromValue(SettingName::CONTEST_ACTIVE_ID);

            return ContestActiveIdSetting::fromValue(
                (int) $settings->find($setting)?->value()?->value() ?? null
            );
        });
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
