<?php

namespace App\Contest\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\EnumValueObject;

final class ContestStatus extends EnumValueObject
{
    const OPEN = 'open';
    const CLOSED = 'closed';
    const DISABLED = 'disabled';

    protected static array $values = [
        ContestStatus::OPEN,
        ContestStatus::CLOSED,
        ContestStatus::DISABLED
    ];
}
