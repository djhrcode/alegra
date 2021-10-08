<?php

namespace App\Setting\Infrastructure\Persistence\Eloquent;

use App\Setting\Domain\Setting;
use App\Setting\Domain\SettingRepository as SettingRepositoryInterface;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;

class SettingRepository implements SettingRepositoryInterface
{
    public function __construct(private SettingModel $model)
    {
    }

    public function find(SettingName $name): ?Setting
    {
        $settingFound = $this->model->newQuery()->where('name', $name->value())->first();

        if (is_null($settingFound))
            return null;

        return Setting::fromPrimitives(
            $settingFound->id,
            $settingFound->name,
            $settingFound->value
        );
    }

    public function update(SettingName $name, SettingValue $value): void
    {
        $this->model->newQuery()
            ->updateOrCreate(['name' => $name->value()], ['value' => $value->value()]);
    }
}
