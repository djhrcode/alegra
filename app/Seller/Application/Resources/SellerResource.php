<?php

namespace App\Seller\Application\Resources;

use App\Seller\Domain\Seller;
use App\Seller\Domain\SellerCollection;
use App\Shared\Application\Resources\Resource;

class SellerResource extends Resource
{
    public function transform(Seller $seller): array
    {
        return [
            'id' => $seller->id()->value(),
            'avatar' => $seller->avatar()->value(),
            'name' => $seller->name()->value(),
            'total_points' => $seller->totalPoints()->value(),
            'remaining_points' => $seller->remainingPoints()->value(),

            'links' => [
                'self' => route('sellers.show', $seller->id()->value()),
                'upvote' => route('sellers.upvote', $seller->id()->value()),
            ]
        ];
    }
}
