<?php

namespace App\Contest\Domain\ValueObjects;

use App\Seller\Domain\ValueObjects\SellerPoints;
use App\Shared\Domain\ValueObject\IntegerValueObject;

final class ContestTotalPoints extends IntegerValueObject
{
    const POINTS_PER_VOTE = SellerPoints::POINTS_PER_VOTE;
}
