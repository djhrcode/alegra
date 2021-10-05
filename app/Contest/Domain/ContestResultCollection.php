<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestName;
use App\Contest\Domain\ValueObjects\ContestStatus;

final class ContestResultCollection
{
    private array $items;

    public function __construct(ContestResult ...$items)
    {
        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }
}
