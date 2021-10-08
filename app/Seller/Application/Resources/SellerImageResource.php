<?php

namespace App\Seller\Application\Resources;

use App\Seller\Domain\SellerImage;
use App\Shared\Application\Resources\Resource;

class SellerImageResource extends Resource
{
    public function transform(SellerImage $sellerImage): array
    {
        return [
            'id' => $sellerImage->id()->value(),
            'description' => $sellerImage->description()?->value(),
            'width' => $sellerImage->width()->value(),
            'height' => $sellerImage->height()->value(),
            'color' => $sellerImage->color()->value(),

            'urls' => [
                'full' => $sellerImage->urls()->full()->value(),
                'regular' => $sellerImage->urls()->regular()->value(),
                'small' => $sellerImage->urls()->small()->value(),
                'thumb' => $sellerImage->urls()->thumb()->value(),
            ],

            'seller' => [
                'id' => $sellerImage->seller()->id()->value(),
                'avatar' => $sellerImage->seller()->avatar()->value(),
                'name' => $sellerImage->seller()->name()->value(),
                'total_points' => $sellerImage->seller()->totalPoints()->value(),
                'remaining_points' => $sellerImage->seller()->remainingPoints()->value(),
            ],

            'links' => [
                'seller' => route('sellers.show', $sellerImage->seller()->id()->value()),
                'upvote' => route('sellers.upvote', $sellerImage->seller()->id()->value()),
            ]
        ];
    }
}
