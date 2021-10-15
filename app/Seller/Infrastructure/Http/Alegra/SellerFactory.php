<?php

namespace App\Seller\Infrastructure\Http\Alegra;

use App\Seller\Domain\Seller;

final class SellerFactory
{
    const DEFAULT_VOTES = 0;
    const DEFAULT_AVATAR = "https://www.gravatar.com/avatar/cafecito?s=200&r=pg&d=mp";

    public function create(array $sellerJson): Seller
    {
        return Seller::fromPrimitives(
            (int) $sellerJson['id'],
            $sellerJson['name'],
            static::DEFAULT_AVATAR,
            static::DEFAULT_VOTES,
            (int) $sellerJson['id'],
        );
    }
}
