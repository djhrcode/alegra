<?php

namespace App\Contest\Application\Resources;

use App\Contest\Domain\ContestResult;
use App\Shared\Application\Resources\Resource;

class ContestResultResource extends Resource
{
    public function transform(ContestResult $contestResult): array
    {
        return [
            'position' => $contestResult->position()->value(),

            'seller' => [
                'id' => $contestResult->seller()->id()->value(),
                'avatar' => $contestResult->seller()->avatar()->value(),
                'name' => $contestResult->seller()->name()->value(),
                'total_points' => $contestResult->seller()->points()->value(),
            ],

            'links' => [
                'seller' => route('sellers.show', $contestResult->seller()->id()->value()),
            ]
        ];
    }
}
