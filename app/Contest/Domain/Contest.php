<?php

namespace App\Contest\Domain;

use App\Contest\Domain\ValueObjects\ContestId;
use App\Contest\Domain\ValueObjects\ContestName;
use App\Contest\Domain\ValueObjects\ContestStatus;

final class Contest
{
    public function __construct(
        private ContestId $id,
        private ContestName $name,
        private ContestStatus $status
    ) {
    }

    public static function fromPrimitives(
        int $id,
        string $name,
        string $status
    ): static {
        return new static(
            ContestId::fromValue($id),
            ContestName::fromValue($name),
            ContestStatus::fromValue($status)
        );
    }

    public function id(): ContestId
    {
        return $this->id;
    }

    public function name(): ContestName
    {
        return $this->name;
    }

    public function status(): ContestStatus
    {
        return $this->status;
    }
}
