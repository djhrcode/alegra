<?php

namespace App\Seller\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\IntegerValueObject;

final class SellerRemainingPoints extends IntegerValueObject
{
    public static function fromPoints(SellerPoints $points, SellerWinningPoints $winningPoints): static
    {
        $remainingPoints = $winningPoints->value() - $points->value();

        return static::fromValue($remainingPoints >= 0 ? $remainingPoints : 0);
    }
}
