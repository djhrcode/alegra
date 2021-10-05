<?php

namespace App\Setting\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\EnumValueObject;

final class SettingName extends EnumValueObject
{
    const CONTEST_ACTIVE_ID = 'contest_active_id';
    const CONTEST_WINNING_POINTS = 'contest_winning_points';

    protected static array $values = [
        SettingName::CONTEST_ACTIVE_ID,
        SettingName::CONTEST_WINNING_POINTS,
    ];
}
