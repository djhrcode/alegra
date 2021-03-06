<?php

namespace App\Seller\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\IntegerValueObject;

final class SellerPoints extends IntegerValueObject
{
    const POINTS_PER_VOTE = 3;
}
