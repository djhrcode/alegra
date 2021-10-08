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
                'is_winner' => $contestResult->sellerIsWinner(),
                'total_points' => $contestResult->seller()->totalPoints()->value(),
                'remaining_points' => $contestResult->seller()->remainingPoints()->value(),
                'winning_points' => $contestResult->seller()->winningPoints()->value()
            ],

            'links' => [
                'seller' => route('sellers.show', $contestResult->seller()->id()->value()),
            ]
        ];
    }
}
