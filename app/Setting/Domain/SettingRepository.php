<?php

namespace App\Setting\Domain;

use App\Setting\Domain\ValueObjects\SettingId;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;

interface SettingRepository
{
    public function find(SettingName $name): ?Setting;
    public function update(SettingName $name, SettingValue $value): void;
}
