<?php

namespace App\Contest\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\IntegerValueObject;

final class ContestVotes extends IntegerValueObject
{
    public function toPoints(): ContestTotalPoints
    {
        return ContestTotalPoints::fromValue(
            $this->value() * ContestTotalPoints::POINTS_PER_VOTE
        );
    }
}
