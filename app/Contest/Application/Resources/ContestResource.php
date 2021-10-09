<?php

namespace App\Contest\Application\Resources;

use App\Contest\Domain\Contest;
use App\Contest\Domain\ContestResult;
use App\Shared\Application\Resources\Resource;

class ContestResource extends Resource
{
    public function transform(Contest $contest): array
    {
        return [

            'id' => $contest->id()->value(),
            'name' => $contest->name()->value(),
            'status' => $contest->status()->value(),
            'total_points' => $contest->totalPoints()->value(),
            'invoice_url' => $contest->invoiceUrl()?->value(),

            'links' => [
                'results' => route('contests.results.list', $contest->id()->value()),
            ]
        ];
    }
}
