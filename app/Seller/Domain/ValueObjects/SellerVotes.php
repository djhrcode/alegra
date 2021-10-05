<?php

namespace App\Seller\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\IntegerValueObject;

final class SellerVotes extends IntegerValueObject
{
    public function toPoints(): SellerPoints
    {
        return SellerPoints::fromValue($this->value() * 3);
    }
}
