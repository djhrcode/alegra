<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestName;
use App\Contest\Domain\ValueObjects\ContestResultPosition;
use App\Contest\Domain\ValueObjects\ContestStatus;
use App\Seller\Domain\Seller;

final class ContestResult
{
    public function __construct(
        private ContestResultPosition $position,
        private Seller $seller
    ) {
    }

    public function position(): ContestResultPosition
    {
        return $this->position;
    }

    public function seller(): Seller
    {
        return $this->seller;
    }
}
