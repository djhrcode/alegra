<?php

namespace App\Setting\Domain;

use App\Setting\Domain\ValueObjects\SettingId;
use App\Setting\Domain\ValueObjects\SettingName;
use App\Setting\Domain\ValueObjects\SettingValue;

final class Setting
{
    public function __construct(
        private SettingId $id,
        private SettingName $name,
        private SettingValue $value
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $value
    ): static {
        return new static(
            SettingId::fromValue($id),
            SettingName::fromValue($name),
            SettingValue::fromValue($value)
        );
    }

    public function id(): SettingId
    {
        return $this->id;
    }

    public function name(): SettingName
    {
        return $this->name;
    }

    public function value(): SettingValue
    {
        return $this->value;
    }

}
